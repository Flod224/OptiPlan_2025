
import statistics
import pandas as pd
from datetime import datetime, timedelta
import uuid
import json


"""Création des classes"""

# Classe Salle
class Rooms:
    def __init__(self, id_room, room_name, location, room_availability):
        self.id_room = id_room
        self.room_name = room_name
        self.location = location
        self.room_availability = room_availability

# Classe Etudiant
class Students:
    def __init__(self, id_student, speciality, degree_attempted, supervisor_id ):
        self.id_student = id_student
        self.speciality = speciality
        self.degree_attempted = degree_attempted
        self.supervisor_id = supervisor_id
        self.planned = False
        self.problem = []
        
#Classe Enseignants
class Teachers:
    def __init__(self, id_teacher, speciality, grade, availability):
        self.id_teacher = id_teacher
        self.speciality = speciality # Liste des spécialités
        self.grade = grade
        self.availability = availability  # Matrice des disponibilités slottime*Jours
        self.student_supervising = 0  # Nombre d'étudiants encadrés
        self.nb_defenses = 0 #Nombre de soutenances attribué 
        self.daily_counter = []
        self.Temporal_matrix = [] #Création de la matrice reprenant toutes les soutenances du prof
        self.wasted_time = 0 #Création de la variable wasted_time

       
# Classe défense
class Defenses:
    def __init__(self, student_id, id_jury, id_room, defense_date, slot_time):
        # Utilisation d'un UUID4 pour un identifiant unique et complexe
        self.id_defense = str(uuid.uuid4())  # Génère une chaîne de type 'f47ac10b-58cc-4372-a567-0e02b2c3d479'
        self.defense_date = defense_date
        self.id_jury = id_jury
        self.id_room = id_room
        self.student_id = student_id
        self.slot_time = slot_time

#Classe jury
class Jury:
    def __init__(self, president_id, supervisor_id, examiner_id):
        self.id_jury = str(uuid.uuid4()) 
        self.president_id = president_id
        self.supervisor_id = supervisor_id
        self.examiner_id = examiner_id



################################################################
  # Nombre de créneaux horaires (time slots) et nombre de jours


import ast
# Charger les données

def charger_donnees( df_teacher, df_room, df_student,df_availavilityTeacher,df_availavilityRoom, horaires_ids,date_debut,date_fin,df_specialites):
    
    #Création des objets
    ################################ 
    # Enseignants
    # Création des objets enseignants
    teachers = []
    for _, row in df_teacher.iterrows():
        prof_id = row['id']

        speciality_dict = df_specialites.set_index('id')['name'].to_dict()

        # Lire les IDs des spécialités
        speciality_ids = json.loads(row['specialities_ids'])


        speciality_names = [speciality_dict[speciality_id] for speciality_id in speciality_ids ]
        


        # Filtrer les disponibilités du professeur en fonction de son prof_id
        prof_disponibilites = df_availavilityTeacher[df_availavilityTeacher['prof_id'] == prof_id]
        plages_horaires_trie = sorted(horaires_ids, key=lambda horaire: horaire['debut'])

        # Groupement des disponibilités par jour
        disponibilites_par_jour = {}
        for jour, groupe in prof_disponibilites.groupby('jour'):  # Grouper les plages par jour
            horaires_libres_ids = groupe['horaire_id'].tolist()
            horaires_libres_ids_trie = [horaire['id'] for horaire in plages_horaires_trie if horaire['id'] in horaires_libres_ids]

        
            # Créer une liste booléenne pour toutes les plages horaires de la journée
            disponibilites_par_jour[jour] = [ True if horaire['id'] in horaires_libres_ids_trie else False for horaire in plages_horaires_trie]

        # Générer tous les jours entre date_debut et date_fin
        tous_les_jours = [
            (date_debut + timedelta(days=i)).strftime('%Y-%m-%d')
            for i in range((date_fin - date_debut).days + 1)
        ]
        # Ajouter les jours manquants (optionnel, si besoin de journées complètes avec False)
        for jour in tous_les_jours:  
            if jour not in disponibilites_par_jour:
                disponibilites_par_jour[jour] = [False] * len(horaires_ids)
                
        # Si nécessaire, convertir en liste de listes triée par jour (selon l'ordre souhaité des jours)
        disponibilites_final = [disponibilites_par_jour[jour] for jour in sorted(disponibilites_par_jour, 
                                                                                 key=lambda d: datetime.strptime(d, '%Y-%m-%d'))]

        # Ajouter l'enseignant avec ses disponibilités
        teachers.append(Teachers(
            id_teacher=row['id'],
            speciality=speciality_names,
            grade=row['grade'],
            availability=disponibilites_final,  # Matrice jour x plages horaires
        ))


    ################################
    # Etudiants
    students = []

    for _, row in df_student.iterrows():
        supervisor_id = str(row['maitre_memoire']) if pd.notna(row['maitre_memoire']) else None  # Conserver les UUID sous forme de chaînes
        speciality_id = row['speciality_id']
        students.append(Students(
            id_student = row['id'],
            speciality = speciality_dict[speciality_id] ,
            degree_attempted= row['niveau_etude'],
            supervisor_id= supervisor_id

        ))
    
    ################################
    #Salles
    rooms = []

    for _, row in df_room.iterrows():
        #Lire les disponibilités    
        salle_id = row['id']
        # Filtrer les disponibilités du professeur en fonction de son prof_id
        salle_disponibilites = df_availavilityRoom[df_availavilityRoom['salle_id'] == salle_id]
        plages_horaires_trie = sorted(horaires_ids, key=lambda horaire: horaire['debut'])

        # Groupement des disponibilités par jour
        disponibilites_par_jour = {}
        for jour, groupe in salle_disponibilites.groupby('jour'):  # Grouper les plages par jour
            horaires_libres_ids = groupe['horaire_id'].tolist()
            horaires_libres_ids_trie = [horaire['id'] for horaire in plages_horaires_trie if horaire['id'] in horaires_libres_ids]

        
            # Créer une liste booléenne pour toutes les plages horaires de la journée
            disponibilites_par_jour[jour] = [ True if horaire['id'] in horaires_libres_ids_trie else False for horaire in plages_horaires_trie]

        # Générer tous les jours entre date_debut et date_fin
        tous_les_jours = [
            (date_debut + timedelta(days=i)).strftime('%Y-%m-%d')
            for i in range((date_fin - date_debut).days + 1)
        ]
        # Ajouter les jours manquants (optionnel, si besoin de journées complètes avec False)
        for jour in tous_les_jours:  
            if jour not in disponibilites_par_jour:
                disponibilites_par_jour[jour] = [False] * len(horaires_ids)
                
        # Si nécessaire, convertir en liste de listes triée par jour (selon l'ordre souhaité des jours)
        disponibilites_final = [disponibilites_par_jour[jour] for jour in sorted(disponibilites_par_jour, key=lambda d: datetime.strptime(d, '%Y-%m-%d'))]

        rooms.append(Rooms(
            id_room=row['id'],
            room_name=row['nom'],
            location=row['localisation'],
            room_availability =disponibilites_final,
        ))

    
    
    # Retourner les objets
    return teachers, rooms, students 

################################################################
#Critère en fonction du maître de mémoire
#Itération 1
#Etape 1 : Création des deux paniers
def create_panier(student_list,teachers_list):
    panier_1 = []
    panier_2 = []
    etudiants_licence = [] #liste des étudiants de Licence
    etudiants_master = [] #liste des masters

    # Parcourir  les étudiants prendre l'ID du sperviseur puis ajouter le nombre d'étudiant supervisé de l'enseignant
    for student in student_list:
        assigned_teacher = next(
                            (teacher for teacher in teachers_list if teacher.id_teacher == student.supervisor_id),
                            None  # Valeur par défaut si aucun élément ne correspond
                        )
        if assigned_teacher is None:
            raise ValueError(f"No teacher found for student {student.id_student} with supervisor_id {student.supervisor_id}")
        else: 
            assigned_teacher.student_supervising += 1

        if student.degree_attempted == 'Licence':
            etudiants_licence.append(student)
        else:
            etudiants_master.append(student)

    # Sélectionner un enseignant avec le nombre d'étudiants encadrés supérieur à 0
    for t in teachers_list:
        if t.student_supervising > 0:
            panier_1.append(t)
        else:
            panier_2.append(t)


    # Retourner les paniers
    return panier_1, panier_2, etudiants_licence, etudiants_master

#----------------------------------------------------------------
#Fonction pour trier les paniers

def trier_paniers(panier1, panier2):
    # Trier le panier 1 par le nombre d'étudiants encadrés dans l'ordre croissant
    panier1.sort(key=lambda x: x.student_supervising, reverse=True)

    #Trier le panier 2 par le grade
    panier2.sort(key=lambda x: x.grade, reverse = False)
    
    quota = panier1[0].student_supervising
    
    #Retourner les paniers triés
    return panier1, panier2, quota

#Fonction pour trier la liste des enseignants
def tri_teacherslist (teachers_list):
    teachers_list.sort(key=lambda x: x.grade, reverse = False)
    return teachers_list


#Fonction pour trier les étudiants en fonction de la spécialité

def tri_student_supervising(student_list, maitre_memoire):
    """
    Prendre le maître de mémoire, puis retourner la liste des étudiants 
    qu'il supervise groupée par spécialités, triée en fonction de la spécialité 
    avec le plus grand nombre d'étudiants (ordre décroissant).
    """

    # Filtrer les étudiants supervisés par le maître de mémoire
    students_with_teacher = [student for student in student_list if student.supervisor_id == maitre_memoire.id_teacher]
    
    # Créer un dictionnaire pour regrouper les étudiants par spécialité
    specialty_groups = {}
    for student in students_with_teacher:
        if student.speciality not in specialty_groups:
            specialty_groups[student.speciality] = []
        specialty_groups[student.speciality].append(student)
    
    # Trier les spécialités par le nombre d'étudiants dans chaque spécialité (ordre décroissant)
    sorted_specialties = sorted(specialty_groups.items(), key=lambda item: len(item[1]), reverse=True)
    
    # Flatten the sorted groups to return a single list of students
    sorted_students = [student for _, group in sorted_specialties for student in group]

    # Retourner la liste des étudiants triés
    return sorted_students


#Créer les groupes des maitres de mémoire 
def create_groupe_mm(student_list,panier1):
     
    #Stocker dans un dictionnaire pour chaque maitre de memoire son groupe d'étudiant
    groupes_mm = {}
    for mm in panier1:
        mini_groupe= tri_student_supervising(student_list, mm)
        if mm.id_teacher not in groupes_mm:
            groupes_mm[mm.id_teacher] = 0
        groupes_mm[mm.id_teacher] = mini_groupe
    return groupes_mm


#-----------------------------------------------------------#
#             Commencement des modifications                #
#-----------------------------------------------------------#
            
#Convertir les disponibilités des licenses en disponibilité de master pour la transition
def Manage_Availabilities(liste):
        
    for i in range(len(liste)):
        
        if i<2:
            
            if liste[i] == True and liste[i+1] == True:  
                liste[i] = True
                
            elif liste[i] == 'Busy' or liste[i+1] == 'Busy':
                liste[i] = 'Busy'
            
            else :
                liste[i] = False
        
        elif i<4: 
            
            if liste[i+1] == True and liste[i+2] == True:
                liste[i] = True
            
            elif liste[i+1] == 'Busy' or liste[i+2] == 'Busy':
                liste[i] = 'Busy'
            
            else :
                liste[i] = False
            
        elif i<6:
            
            if liste[i+2] == True and liste[i+3] == True:  
                liste[i] = True
            
            elif liste[i+2] == 'Busy' or liste[i+3] == 'Busy':
                liste[i] = 'Busy'
            
            else :
                liste[i] = False
                    
    # Suppimer les index inutiles
        
    liste.pop(len(liste)-1)
        
    liste.pop(len(liste)-1)

    liste.pop(len(liste)-1)
            
    liste.pop(len(liste)-1)
        
    return liste


##############
# Fonction pour créer les jurys et planifier les soutenances
def createJury(date_debut, panier1, groupemm, plages_horaires_L, plages_horaires_M, 
               salles, teachers_list, L_students, M_students, 
               Max_soutenance_per_day, g1, g2, Max_jour, quota):
    
    #Initialisation
    date_courante = date_debut
    jour = 0
    jury_list = []
    defenses_list = []
    teachers_list = tri_teacherslist(teachers_list) #Trier la liste des enseignants par grade
      
    
    cond1 = True #condition pour ajouter la journée à la matrice Temporal_matrix (ne pas la mettre 2 fois)
    max_plages = max(len(plages_horaires_L), len(plages_horaires_M)) # connaitre la dimension de la matrice Temporal_matrix
    dernier_jour = 0 #Variable pour récuperer le dernier jour utilisé pour une soutenance
    plages = plages_horaires_L #On commence par les licences
    g = g1
    transition = False
    
    
    # BOUCLE PRINCIPALE
    while len(panier1)> 0 and jour<Max_jour:

        if cond1: #Verifier que la journée n'as pas été crée dans les matrices des soutenance et celles des erreurs

            #Création matrice Soutenances des profs chaque jours
            for e in teachers_list:
                liste = [0 for _ in range(max_plages)]
                e.Temporal_matrix = e.Temporal_matrix + [liste]

                if len(e.daily_counter)<jour+1:
                    e.daily_counter.append(0)
            
            cond1 = False
            

        #Creation d'une matrice pour chaque étudiant afin de retourner les erreurs chaques jours
        if not transition:
            for st in L_students:
                liste1 = ['' for _ in range(len(plages_horaires_L))]
                st.problem = st.problem + [liste1]
        
        if transition:
            for st in M_students:
                liste2 = ['' for _ in range(len(plages_horaires_M))]
                st.problem = st.problem + [liste2]


        # Parcourir chaque créneau horaire de la journée
        for slot_index, _ in enumerate(plages) :

            #Pour chaque créneau on parcours les salles
            for k, s in enumerate(salles):
                
                if  s.room_availability[jour][slot_index]:  # Si le créneau est déjà pris, on passe au suivant
                    R = [] #Variable pour les IDs temporaire avant d'assigner à une défense

                    #On parcours les maitres de mémoires du panier 1
                    for mm in panier1:
                        
                        if mm.availability[jour][slot_index] == False:
                            #Remplissage de la matrice d'erreur dans le cas où le maitre de mémoire est indisponible
                            for st in groupemm[mm.id_teacher]:
                                if st in L_students and not transition:
                                    st.problem[jour][slot_index] = 'Maitre de mémoire'
                                
                                if st in M_students and transition:
                                    st.problem[jour][slot_index] = 'Maitre de mémoire'

                        #Vérifier les disponibilités de l'enseignement et qu'il n'est pas programmé dans une autre salle
                        if (mm.availability[jour][slot_index] == True and mm.daily_counter[jour]<Max_soutenance_per_day):
                            
                            #On parcours les étudiants du maitre de mémoire 
                            for st in groupemm[mm.id_teacher]:
                                
                                if (st.degree_attempted == 'Licence' and not transition) or (st.degree_attempted == 'Master' and transition):
                                    #Créer le groupe constitué de l'étudiant du maitre de mémoire 'mm'
                                    R.append(st)
                                    R.append(mm)
                                    
                                    #Compteur pour savoir si on est à la fin du for
                                    compt_e = 0

                                    #Compteur pour trouver quel examinateur possible à le moins de soutenance
                                    e_min = False

                                    # On cherche un examinateur
                                    for e in teachers_list:
                                        compt_e +=1

                                        #Verification que l'examinateur verifie tous les critères requis
                                        if (e.id_teacher != R[1].id_teacher and
                                            R[0].speciality in e.speciality and 
                                            e.availability[jour][slot_index] == True and 
                                            e.daily_counter[jour]<Max_soutenance_per_day ):

                                            #Si c'est un maitre de mémoire potentiel, ajouter les étudiants encore à charge au compteur total
                                            if e in panier1:
                                                if not e_min:
                                                    e_min = e.nb_defenses + len(groupemm[e.id_teacher])

                                                #Remplacer e_min si on trouve un prof avec moins de soutenances    
                                                elif e.nb_defenses+ len(groupemm[e.id_teacher]) < e_min:

                                                    e_min = e.nb_defenses
                                                    e_person = e
                                            
                                            else:
                                                if not e_min:
                                                    e_min = e.nb_defenses

                                                elif e.nb_defenses< e_min:

                                                    e_min = e.nb_defenses
                                                    e_person = e

                                            #Si l'enseignant n'a pas atteint le nombre de soutenance maximale on l'ajoute au groupe provisoire
                                            if e in panier1:
                                                if e.nb_defenses < quota-len(groupemm[e.id_teacher]):
                                                    R.append(e)
                                                    break

                                            elif(e.nb_defenses < quota):
                                                R.append(e)
                                                break

                                            #Si à la fin de la liste tout les enseignants répondant aux critères ont atteint le maximum
                                            #On prend le prof avec le minimum
                                            if compt_e == len(teachers_list):
                                                if e_min:
                                                    R.append(e_person)
                                                    break

                                    else :
                                        #si à la fin aucun enseignant ne réponds au criteres, on supprime le groupe temporaire et on passe au creneau suivant
                                        R.clear()

                                        st.problem[jour][slot_index] = 'Examinateur'
                                        
                                                                        
                                    if R :
                                        #Si on a le groupe rempli, on cherche le président de jury
    
                                        #Compteur pour savoir si on est à la fin du for
                                        compt_p = 0
                                        #Compteur pour trouver quel maitre de jury possible à le moins de soutenance
                                        f_min = False
                                        for f in teachers_list:
                                            compt_p +=1
                                            #Verification que le maitre de jury verifie tous les critères requis
                                            if (f.id_teacher != R[1].id_teacher and 
                                                f.id_teacher != R[2].id_teacher and
                                                
                                                f.grade >=g and 
                                                f.grade>= (R[1].grade) and 
                                                f.grade >= (R[2].grade) and 
                                                f.availability[jour][slot_index] == True and 
                                                f.daily_counter[jour]<Max_soutenance_per_day):
    
                                                #Si c'est un maitre de mémoire potentiel, ajouter les étudiants encore à charge au compteur total
                                                if f in panier1:
                                                    if not f_min:
    
                                                        f_min = f.nb_defenses + len(groupemm[f.id_teacher])
    
                                                    #Remplacer e_min si on trouve un prof avec moins de soutenances
                                                    elif f.nb_defenses+ len(groupemm[f.id_teacher]) < f_min:
    
                                                        f_min = f.nb_defenses
                                                        f_person = f 
                                                else:
                                                    if not f_min:
                                                        f_min = f.nb_defenses
                                                    elif f.nb_defenses< f_min:
                                                        f_min = f.nb_defenses
                                                        f_person = f
    
                                                #Si l'enseignant n'a pas atteint le nombre de soutenance maximale on l'ajoute au groupe provisoire
                                                if f in panier1:
                                                    if f.nb_defenses < quota-len(groupemm[f.id_teacher]):
                                                        R.append(f)
                                                        break
    
                                                elif(f.nb_defenses < quota):
                                                    R.append(f)
                                                    break
    
                                                #Si à la fin de la liste tout les enseignants répondant aux critères ont atteint le maximum
                                                #On prend le prof avec le minimum
                                                if compt_p == len(teachers_list):
                                                    if f_min:
                                                        R.append(f_person)
                                                        break
                                        else :
                                            R.clear()
                                            st.problem[jour][slot_index] = 'Président de Jury'
                                            
                                    if R :
                                        break #Break du for pour les étudiants du maitre de mémoire

                                #Pour d'abord terminer les étudiants pour les licence avant de passer au masters    
                                else:
                                    continue
                            
                            if R :
                                break #Break du for pour les maitres de mémoire dans le panier 1                       
                          
                    if R :
                        s.room_availability[jour][slot_index] = False
                        R[0].planned= True
                        
                        if dernier_jour<jour : #pour gerer le cas ou les masters finissent avant les licences (pour l'affichage)
                            dernier_jour = jour
                            
                        R[0].problem.clear() #Etudiant casé = Suppression de sa matrice d'erreur
                        
                        
                        #Gestion des matrice d'erreur des étudiant lorsqu'un étudiant est casé
                        if not transition:
                            L_students.remove(R[0])
                            
                            for T in salles:
                                if T.room_availability[jour][slot_index] == True:
                                    break
                             
                            else:
                                for st in L_students:
                                    #Suppression des erreurs des étudiant qui avaient une erreur sur ce créneau car il a été attribué
                                    st.problem[jour][slot_index] = ''
                        
                        if transition:
                            M_students.remove(R[0])
                            
                            for T in salles:
                                if T.room_availability[jour][slot_index] == True:
                                    break
                            
                            else:
                            
                                for st in M_students:
                                    #Suppression des erreurs des étudiant qui avaient une erreur sur ce créneau car il a été attribué
                                    st.problem[jour][slot_index] = ''
                                
                                for st in L_students:
                                    #Gestion des matrices problem des étudiants en licences non casés Dans le cas où l'on traite des masters
                                    #On la garde en format licences (10 cases) pour le calcul
                                    #slot_index : slots de masters (6 cases)
                                    #slot : Conversion en format licences(10 cases)
                                    if slot_index%2 == 0:
                                        slot = slot_index
                                    
                                    else:
                                        slot = slot_index + 1
                                    
                                    if slot_index<2:
                                        st.problem[jour][slot] = ''
                                        st.problem[jour][1] = ''
                                    
                                    elif slot_index<4:
                                        st.problem[jour][slot +1] = ''
                                        st.problem[jour][4]=''
                                    
                                    elif slot_index<6:
                                        st.problem[jour][slot +2] = ''
                                        st.problem[jour][7] = ''
                         
                        
                        for i in range(1,4):
                            R[i].availability[jour][slot_index] = 'Busy'
                            R[i].daily_counter[jour] +=1
                            R[i].nb_defenses += 1
                            if not transition :
                                R[i].Temporal_matrix[jour][slot_index] = 1 #Remplissage de la matrice des soutenances pour le cas des licences
                            
                            else:
                                #Gestion de la matrice Wasted_time Dans le cas où l'on traite des masters
                                #On la garde en format licences (10 cases) pour le calcul
                                #slot_index : slots de masters (6 cases)
                                #slot : Conversion en format licences(10 cases)
                                if slot_index%2 == 0:
                                    slot = slot_index
                                
                                else:
                                    slot = slot_index + 1
                                
                                if slot_index<2:
                                    R[i].Temporal_matrix[jour][slot] = 1
                                    if R[i].Temporal_matrix[jour][1]==0:
                                        R[i].Temporal_matrix[jour][1] = "impossible"
                                
                                elif slot_index<4:
                                    R[i].Temporal_matrix[jour][slot +1] = 1
                                    if R[i].Temporal_matrix[jour][4]==0:
                                        R[i].Temporal_matrix[jour][4] = "impossible"
                                
                                elif slot_index<6:
                                    R[i].Temporal_matrix[jour][slot +2] = 1
                                    if R[i].Temporal_matrix[jour][7]==0:
                                        R[i].Temporal_matrix[jour][7] = "impossible"

                            
                        # Supprimer l'étudiant (R[0]) de la liste des étudiants du maître de mémoire (mm)
                        groupemm[R[1].id_teacher].remove(R[0])  # Retirer l'étudiant de la liste du groupe mm

                        if not groupemm[R[1].id_teacher]:
                            
                            panier1.remove(R[1])  # Supprimer le maitre de mémoire dans le panier 1 si il n'a plus d'étudiants

                        #Ajouter dans la liste membre du jury
                        jury = Jury( president_id= R[3].id_teacher,
                                     supervisor_id = R[1].id_teacher,
                                     examiner_id = R[2].id_teacher
                                    )
                        jury_list.append(jury)
                        
                        #Ajouter dans Defenses
                        
                        defense = Defenses( student_id= R[0].id_student,
                                            id_jury = jury.id_jury,
                                            id_room= s.id_room,
                                            defense_date = date_courante,
                                            slot_time= plages[slot_index]
                                            )
                        defenses_list.append(defense)
                    
                if len(L_students) ==0 and not transition:
                    break #Break du for pour les salles
                    
            #Transition dans le cas ou les étudiants de licences sont casés
            if len(L_students)==0 and not transition:
                
                jour = 0
                
                date_courante = date_debut
                    
                for j in range(Max_jour):
                    
                    for s in salles:   #Modifier dispo des salles pour correspondre au master
                        
                        s.room_availability[j] = Manage_Availabilities(s.room_availability[j])
                
                    for t in teachers_list: #Modifier dispo des enseignants pour correspondre au master
                    
                        t.availability[j] = Manage_Availabilities(t.availability[j])
                    
                plages = plages_horaires_M # On passe aux masters une fois que les licences sont faites
                
                g = g2
                
                transition = True
                
                break #Break du for pour les times_slots

        else :
            #else au for des times_slots pour passer au jour suivant une fois avoir parcouru tout les times_slots
            date_courante += timedelta(days=1)
            
            if not transition:
                
                if jour +1 < Max_jour:
                    jour += 1
                
                #Transition dans le cas ou les étudiants de licences ne sont pas casés
                else:  
                    jour = 0
                    
                    date_courante = date_debut
                        
                    for j in range(Max_jour):
                        
                        for s in salles:   #Modifier dispo des salles pour correspondre au master
                            
                            s.room_availability[j] = Manage_Availabilities(s.room_availability[j])
                    
                        for t in teachers_list: #Modifier dispo des enseignants pour correspondre au master
                        
                            t.availability[j] = Manage_Availabilities(t.availability[j])
                        
                    plages = plages_horaires_M # On passe aux masters une fois que les licences sont faites
                    
                    g = g2
                    
                    transition = True
            
            else:
                jour += 1
                
            if jour>dernier_jour:
                cond1 = True
            
#=========          FIN DE LA BOUCLE PRINCIPALE          ========================================================================


    liste_problem = []
      
    if len(panier1) == 0:
        print("Planning créé avec succès en : ", dernier_jour+1, " jour(s)\n")
        
    else:
        
        for x in L_students:
            liste_problem.append(x.id_student)
        
        for y in M_students:
            liste_problem.append(y.id_student)
            
        print("\nil y a une erreur")
        print("\nPlanning partiel créé en : ", dernier_jour+1, " jour(s)\n")

    return jury_list, defenses_list, dernier_jour+1, liste_problem

#Fonction qui calcul la métrique Wasted_time
def Calcul_wasted_time(teacher_list, max_soutenances_j, compt_temps_midi):
    if max_soutenances_j>5:
        max_soutenances_j = 5
        
    total_wasted_time = 0
    for e in teacher_list:
        n = len(e.Temporal_matrix)
        compt_T = 0
        compt_0 = 0
        memoire = 0
        waste_j = 0

        #Parcours de la matrice à l'envers
        for j in range(n-1, -1, -1):
            cond = False #Condition pour savoir quels 0 comptent pour le wasted_time
            compt_j = 0  #Compteur journalier
            compt_0 = 0  #Compteur Total
            compt_T_copy = compt_T #Copie du compteur total pour s'assurer qu'il y a eu une soutenance
            
            for index, i in enumerate(e.Temporal_matrix[j][::-1]):
                
                if i!=0 and i!='impossible':   
                    cond = True
                    compt_T = compt_T + 1
                    compt_j = compt_j + 1
                    
                    #Cas ou on augmente le wasted_time car on a un espace entre deux soutenances
                    if compt_0 != 0: 
                        e.wasted_time = e.wasted_time + compt_0*memoire
                        compt_0 = 0

                    #Cas ou on commence à compter les 0 (espace entre deux soutenances)
                    else:
                        memoire = i
                    
                #Comptage des espaces vides entre deux soutenances
                if i==0 and cond:
                    if compt_temps_midi:
                        compt_0 = compt_0 + 1
                    
                    elif index != 5 and index != 4:
                        compt_0 = compt_0 + 1
                        
    
            #Calcul du wasted_time
            
            #Si le prof n'a pas atteint le maximum de soutenance sur le jour, on sauve le temps perdu dans une variable temporaire waste_j
            if compt_j < max_soutenances_j:
                #Cas où il ne lui restait plus assez de soutenances pour faire le maximum de la journée
                if compt_T < max_soutenances_j :
                    waste_j = waste_j + compt_T - compt_j
                else:
                    waste_j = waste_j + max_soutenances_j - compt_j
            
            #Si nous avons des jours vides, s'assurer qu'ils sont entre deux jours avec des soutenances avant d'ajouter waste_j
            #au wasted_time
            if compt_T != compt_T_copy:
                e.wasted_time = e.wasted_time + waste_j
                waste_j = 0

        total_wasted_time = total_wasted_time + e.wasted_time
    
    moyenne_wasted_time = total_wasted_time / (len(teacher_list))
    
    return moyenne_wasted_time


################################################################
#Fontion pour le calcul de l'écart-type
import numpy as np
def metric_equilibrage(teachers_list):
    # Extraire le nombre de soutenances de chaque professeur à partir des objets Teacher
    nb_soutenances_prof = [teacher.nb_defenses for teacher in teachers_list]
    
    # Calculer la moyenne des soutenances
    moyenne_soutenances = np.mean(nb_soutenances_prof)
    
    # Calculer le nombre maximum de soutenances
    max_soutenances = np.max(nb_soutenances_prof)
    min_soutenances = np.min(nb_soutenances_prof)


    metric = statistics.stdev(nb_soutenances_prof)


    return metric, max_soutenances, min_soutenances, moyenne_soutenances

#-----------------------------------------------------------#
#                   Fin des modifications                   #
#-----------------------------------------------------------#



#Fonction pour générer les soutenances
def generer_planning_par_jour(defenses_list, jury_list, students, teachers, rooms, save_to_excel=True):
    # Créer une liste pour stocker les données du planning
    planning_data = []

    for defense in defenses_list:
        try:
            
            # Récupérer les informations de chaque entité avec gestion des cas absents
            student = next((st for st in students if st.id_student == defense.student_id), None)
            if not student:
                raise ValueError(f"Étudiant introuvable pour l'ID {defense.student_id}")

            jury = next((j for j in jury_list if j.id_jury == defense.id_jury), None)
            if not jury:
                raise ValueError(f"Jury introuvable pour l'ID {defense.id_jury}")

            room = next((r for r in rooms if r.id_room == defense.id_room), None)
            if not room:
                raise ValueError(f"Salle introuvable pour l'ID {defense.id_room}")

            president = next((t for t in teachers if t.id_teacher == jury.president_id), None)
            examiner = next((t for t in teachers if t.id_teacher == jury.examiner_id), None)
            supervisor = next((t for t in teachers if t.id_teacher == jury.supervisor_id), None)

            # Ajouter une ligne au planning avec toutes les informations
            planning_data.append({
                "jour": defense.defense_date.strftime("%Y/%m/%d"),
                "Plage Horaire": defense.slot_time,
                "jury_id":jury.id_jury,
                "president": president.id_teacher if president else "N/A",
                "examinateur": examiner.id_teacher if examiner else "N/A",
                "rapporteur": supervisor.id_teacher if supervisor else "N/A",
                "etudiant_id": student.id_student if student else "N/A",
                "niveau_etude": student.degree_attempted if student else "N/A",
                "salle_id": room.id_room if room else "N/A"
            })
        except ValueError as e:
            print(f"Erreur : {e}")
            continue
    

    # Créer un DataFrame pour organiser les données de manière tabulaire
    planning_df = pd.DataFrame(planning_data)
    grouped_data = planning_df.groupby("jour").apply(lambda x: x.to_dict(orient="records")).to_dict()
    


    # Exporter le planning vers un fichier Excel si nécessaire
    if save_to_excel:
        planning_df.to_excel("planning_defenses.xlsx", index=False)
        print("Le planning des soutenances a été enregistré dans 'planning_defenses.xlsx'.\n")


    return grouped_data




