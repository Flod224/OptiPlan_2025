from flask import Flask, json, request, jsonify
import pandas as pd
from datetime import datetime, timedelta
from heuristique1 import *  # Importer vos fonctions et classes existantes

import traceback
 
app = Flask(__name__)

@app.route("/")
def home():
    return "Hello, Flask!"
# Route principale pour recevoir les données
@app.route('/generate_planning', methods=['GET', 'POST'])
 
def generate_planning():
    
    try:
        # 1. Récupérer les données JSON envoyées par Laravel
        data = request.get_json()
        if not data:
            return jsonify({"error": "No data received"}), 400
        

       
        # 2. Extraire les différentes entités depuis les données reçues
        choix_heuristique = data.get('choix_heuristique',1)
        etudiants = data.get('etudiants', [])
        professeurs = data.get('professeurs', [])
        specialites = data.get('specialities', {})
        salles = data.get('salles', [])
        session = data.get('session', {})
        type_soutenance = data.get('type_soutenances')
        plages_horaires_L = data.get('plages_horaires_L')
        plages_horaires_M = data.get('plages_horaires_M')
        horaires = data.get('horaire')  
        availavilityTeacher = data.get('availabilityteachers')
        availavilityRoom = data.get('availabilityroom')
        # Chargement des JSON en mémoire
        df_teacher = pd.DataFrame(professeurs)
        df_room = pd.DataFrame(salles)
        df_student = pd.DataFrame(etudiants)
        df_specialites = pd.DataFrame(specialites)
        df_availavilityTeacher = pd.DataFrame(availavilityTeacher)
        df_availavilityRoom = pd.DataFrame(availavilityRoom)
        #df_teacher['specialities_ids'] = df_teacher['specialities_ids'].apply( lambda x: json.loads(x) if isinstance(x, str) else x)

        max_soutenance_per_day = session.get('nb_soutenance_max_prof', 4)
        grade_licence = session.get('grademin_licence') #Le grade minimum pour être president en Licence
        grade_master = session.get('grademin_master') #Le grade minimum pour être president en Master

        
        # Vérifications de base
        if not etudiants or not professeurs or not salles:
            return jsonify({"error": "Missing critical data (students, teachers, or rooms)"}), 400
       

        if type_soutenance == "Pre-Soutenance":
            date_debut = datetime.strptime(session.get('session_start_PreSout', datetime.now().strftime('%Y-%m-%d')), '%Y-%m-%d')
            date_fin = datetime.strptime(session.get('session_end_PreSout', datetime.now().strftime('%Y-%m-%d')), '%Y-%m-%d')
            Max_jour = (date_fin - date_debut).days +1
            # 3. Charger les données dans les objets appropriés
            enseignants, salles, etudiants = charger_donnees(df_teacher, df_room, 
                                                         df_student,df_availavilityTeacher,df_availavilityRoom,
                                                         horaires,date_debut,date_fin,df_specialites)
        elif type_soutenance == "Soutenance":
            date_debut = datetime.strptime(session.get('session_start_Sout', datetime.now().strftime('%Y-%m-%d')), '%Y-%m-%d')
            date_fin = datetime.strptime(session.get('session_end_Sout', datetime.now().strftime('%Y-%m-%d')), '%Y-%m-%d')
            Max_jour = (date_fin - date_debut).days +1
            # 3. Charger les données dans les objets appropriés
            enseignants, salles, etudiants = charger_donnees(df_teacher, df_room, 
                                                         df_student,df_availavilityTeacher,df_availavilityRoom,
                                                         horaires,date_debut,date_fin,df_specialites)
        else:
            return jsonify({"error": "Invalid type of soutenance"}), 400
 

 
       ########################################################################
        if choix_heuristique :
           
            
            if choix_heuristique == "1" :
                #Méthode d'exécution sur l'heuristique 1

                # 4. Exécuter votre algorithme
                panier_1, panier_2, L_student, M_student = create_panier(etudiants, enseignants)
                panier_1, panier_2, quota = trier_paniers(panier_1, panier_2)
                groupes_mm = create_groupe_mm(etudiants, panier_1)

                jury_list, defenses_list, jour_h1, probleme = createJury(
                    date_debut, panier_1, groupes_mm, plages_horaires_L, plages_horaires_M,
                    salles, enseignants, L_student, M_student,
                    max_soutenance_per_day, grade_licence, grade_master, Max_jour, quota)
                
                # 5. Générer le planning en DataFrame et exporter en JSON
                planning_df_h1 = generer_planning_par_jour(defenses_list, jury_list, etudiants, enseignants, salles)
                

                #Metrique d'exécution sur l'équilibrage
                metric_h1_equilibrage , max_soutenances, min_soutenances, moyenne_soutenances = metric_equilibrage(enseignants)

                metric_h1_wasted_time = Calcul_wasted_time(enseignants, max_soutenance_per_day, compt_temps_midi = False)
                
                result = {
                    "success": True,
                    "message": "Planning OK",
                    "plannings": {
                        "soutenances": planning_df_h1,
                        "type": type_soutenance,
                        "metrics": {
                            "equilibrage": metric_h1_equilibrage,
                            "wasted_time": metric_h1_wasted_time,
                            "nbre_jour": jour_h1
                        },
                        "probleme": probleme 
                    }
                }
                

            ########################################################################

            # Méthode d'exécution sur l'heuristique 2
            elif choix_heuristique == "2":
                from heuristique2 import build_schedule_h2
                defenses_list_h2, jury_list_h2 = build_schedule_h2(
                teachers=enseignants,
                rooms=salles,
                students=etudiants,
                date_debut=date_debut,
                max_defenses_per_day=max_soutenance_per_day
                )

                # 3) Générer un tableau planning (optionnel, même format que H1)
                planning_df_h2 = generer_planning_par_jour(
                    defenses_list_h2,
                    jury_list_h2,
                    etudiants,
                    enseignants,
                    salles,
                    save_to_excel=False  # Ou True si vous voulez
                )

                # 4) (Optionnel) Calcul de métriques "H2"
                # ou on peut réutiliser metric_equilibrage(...) si on veut
                metric_eq, max_sout, min_sout, moy_sout = metric_equilibrage(enseignants)
                wasted_time = Calcul_wasted_time(enseignants, max_soutenance_per_day, compt_temps_midi=False)

                result = {
                    "success": True,
                    "message": "Planning OK (Heuristique 2)",
                    "plannings": {
                        "soutenances": planning_df_h2,
                        "type": type_soutenance,
                        "metrics": {
                            "equilibrage": metric_eq,
                            "wasted_time": wasted_time
                        }
                    }
                }  





            # Retour des données
            
        else:
            result = {
                "success": False,
                "message": "Invalid choice of heuristic.",
                "details": "No heuristic choice provided in the request."
            }
        return jsonify(result), 200
 
 
    except Exception as e:
        # Retourner une erreur en cas de problème
      
        return jsonify({"error": "An error occurred", "details": str(e), "trace": traceback.format_exc()}), 500
   
 
 
if __name__ == "__main__":
    app.run(debug=True)
