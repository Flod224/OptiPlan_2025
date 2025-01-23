import pandas as pd
import statistics
import numpy as np
from datetime import datetime, timedelta
import uuid

"""
------------------------------------------------------------------------------
             1) Classes identiques à l'heuristique 1
------------------------------------------------------------------------------
"""

class Rooms:
    def __init__(self, id_room, room_name, location, room_availability):
        self.id_room = id_room
        self.room_name = room_name
        self.location = location
        self.room_availability = room_availability  # Matrice [jours][slots] de bool

class Students:
    def __init__(self, id_student, speciality, degree_attempted, supervisor_id):
        self.id_student = id_student
        self.speciality = speciality
        self.degree_attempted = degree_attempted
        self.supervisor_id = supervisor_id
        self.planned = False
        self.problem = []

class Teachers:
    def __init__(self, id_teacher, speciality, grade, availability):
        self.id_teacher = id_teacher
        self.speciality = speciality  # Liste de spécialités
        self.grade = grade
        self.availability = availability  # Matrice [jours][slots] de bool ou "Busy"
        self.student_supervising = 0
        self.nb_defenses = 0
        self.daily_counter = []
        self.Temporal_matrix = []
        self.wasted_time = 0

class Defenses:
    def __init__(self, student_id, id_jury, id_room, defense_date, slot_time):
        self.id_defense = str(uuid.uuid4())
        self.defense_date = defense_date
        self.id_jury = id_jury
        self.id_room = id_room
        self.student_id = student_id
        self.slot_time = slot_time

class Jury:
    def __init__(self, president_id, supervisor_id, examiner_id):
        self.id_jury = str(uuid.uuid4())
        self.president_id = president_id
        self.supervisor_id = supervisor_id
        self.examiner_id = examiner_id

"""
------------------------------------------------------------------------------
     2) Fonction de chargement identique à l'heuristique 1 (charger_donnees)
------------------------------------------------------------------------------

def charger_donnees(
    df_teacher, 
    df_room, 
    df_student,
    df_availavilityTeacher,
    df_availavilityRoom,
    horaires_ids,
    date_debut,
    date_fin,
    df_specialites
):
    # Dictionnaire pour convertir un ID de spécialité -> nom
    speciality_dict = df_specialites.set_index('id')['name'].to_dict()

    # -------------------- ENSEIGNANTS --------------------
    teachers = []
    for _, row in df_teacher.iterrows():
        prof_id = row['id']
        speciality_ids = row['specialities_ids']
        speciality_names = [
            speciality_dict[sid] for sid in speciality_ids
        ]

        # Disponibilités
        prof_disponibilites = df_availavilityTeacher[df_availavilityTeacher['prof_id'] == prof_id]
        plages_horaires_trie = sorted(horaires_ids, key=lambda h: h['debut'])

        disponibilites_par_jour = {}
        for jour, groupe in prof_disponibilites.groupby('jour'):
            horaires_libres_ids = groupe['horaire_id'].tolist()
            # On filtre la liste de slots
            disponibilites_par_jour[jour] = [
                (slot['id'] in horaires_libres_ids) for slot in plages_horaires_trie
            ]

        # Générer tous les jours entre date_debut et date_fin
        nb_jours = (date_fin - date_debut).days + 1
        tous_les_jours = [
            (date_debut + timedelta(days=i)).strftime('%Y-%m-%d')
            for i in range(nb_jours)
        ]
        for d in tous_les_jours:
            if d not in disponibilites_par_jour:
                disponibilites_par_jour[d] = [False]*len(plages_horaires_trie)

        # Ordonner la matrice par date
        sorted_days = sorted(disponibilites_par_jour.keys(), key=lambda d: datetime.strptime(d, '%Y-%m-%d'))
        availability_matrix = [disponibilites_par_jour[d] for d in sorted_days]

        teachers.append(Teachers(
            id_teacher=row['id'],
            speciality=speciality_names,
            grade=row['grade'],
            availability=availability_matrix
        ))

    # -------------------- ETUDIANTS --------------------
    students = []
    for _, row in df_student.iterrows():
        supervisor_id = str(row['maitre_memoire']) if pd.notna(row['maitre_memoire']) else None
        spec_id = row['speciality_id']
        spec_name = speciality_dict[spec_id] if spec_id in speciality_dict else "Inconnue"

        students.append(Students(
            id_student=row['id'],
            speciality=spec_name,
            degree_attempted=row['niveau_etude'],  # ex. "Licence" ou "Master"
            supervisor_id=supervisor_id
        ))

    # -------------------- SALLES --------------------
    rooms = []
    for _, row in df_room.iterrows():
        salle_id = row['id']
        salle_disponibilites = df_availavilityRoom[df_availavilityRoom['salle_id'] == salle_id]
        plages_horaires_trie = sorted(horaires_ids, key=lambda h: h['debut'])

        dispo_par_jour = {}
        for jour, groupe in salle_disponibilites.groupby('jour'):
            horaires_ids_libres = groupe['horaire_id'].tolist()
            dispo_par_jour[jour] = [
                (slot['id'] in horaires_ids_libres) for slot in plages_horaires_trie
            ]

        nb_jours = (date_fin - date_debut).days + 1
        tous_les_jours = [
            (date_debut + timedelta(days=i)).strftime('%Y-%m-%d')
            for i in range(nb_jours)
        ]
        for d in tous_les_jours:
            if d not in dispo_par_jour:
                dispo_par_jour[d] = [False]*len(plages_horaires_trie)

        sorted_days = sorted(dispo_par_jour.keys(), key=lambda d: datetime.strptime(d, '%Y-%m-%d'))
        availability_matrix = [dispo_par_jour[dy] for dy in sorted_days]

        rooms.append(Rooms(
            id_room=row['id'],
            room_name=row['nom'],
            location=row['localisation'],
            room_availability=availability_matrix
        ))

    return teachers, rooms, students

"""
"""
------------------------------------------------------------------------------
   3) Logique de génération FAÇON H2 (mais appliquée aux objets de H1)
------------------------------------------------------------------------------
"""

def build_schedule_h2(teachers, rooms, students, date_debut, max_defenses_per_day=4):
    """
    Exemple de logique de génération (H2). 
    On parcourt chaque étudiant et on essaye de l'assigner à un créneau :
      - Le superviseur doit être libre
      - Une salle doit être libre
      - On cherche un "président" (prof != superviseur, dispo)
      - On cherche un "examinateur" (prof != superviseur, dispo, et spécialité correspond)
    On crée alors un Jury + une Defense.
    
    :param teachers: liste d'objets Teachers
    :param rooms: liste d'objets Rooms
    :param students: liste d'objets Students
    :param date_debut: datetime (pour construire la date de la défense)
    :param max_defenses_per_day: nombre max. de soutenances par enseignant sur une journée
    :return: (defenses_list, jury_list)
    """
    defenses_list = []
    jury_list = []

    # Pour récupérer le nombre de jours (matrice dispo)
    if not teachers:
        return (defenses_list, jury_list)

    # Suppose que tous les teachers ont la même taille de matrice 
    nb_jours = len(teachers[0].availability)  
    if nb_jours == 0:
        return (defenses_list, jury_list)

    # On boucle sur chaque étudiant
    for student in students:
        # Trouver superviseur
        supervisor = next((t for t in teachers if t.id_teacher == student.supervisor_id), None)
        if supervisor is None:
            # Superviseur introuvable => on skip
            continue

        assigned = False
        for day_index in range(nb_jours):
            # Combien de slots ?
            slots_count = len(supervisor.availability[day_index])

            # Vérifier le compteur journalier du superviseur
            if len(supervisor.daily_counter) <= day_index:
                supervisor.daily_counter.append(0)  # initialise
            if supervisor.daily_counter[day_index] >= max_defenses_per_day:
                # superviseur a déjà atteint son max dans cette journée
                continue

            for slot_index in range(slots_count):
                sup_is_free = supervisor.availability[day_index][slot_index]
                if not sup_is_free:
                    continue  # superviseur pas libre

                # Vérif si la salle est libre
                candidate_room = None
                for rm in rooms:
                    # On peut aussi vérifier le compteur journalier d'une salle si nécessaire
                    if rm.room_availability[day_index][slot_index]:
                        candidate_room = rm
                        break
                if candidate_room is None:
                    continue  # aucune salle libre

                # Vérifier si superviseur n'a pas déjà max soutenances ce jour
                # (on l'a déjà partiellement check, mais on refait si besoin)
                if supervisor.daily_counter[day_index] >= max_defenses_per_day:
                    break

                # Trouver un président (diff. superviseur, dispo, pas saturé)
                president = next((
                    p for p in teachers
                    if p.id_teacher != supervisor.id_teacher
                    and p.availability[day_index][slot_index] is True
                    and (len(p.daily_counter) <= day_index or p.daily_counter[day_index] < max_defenses_per_day)
                ), None)

                if president is None:
                    continue  # pas de président possible sur ce slot
                
                # Trouver un examinateur (diff. superviseur, dispo, qui a la spécialité)
                examiner = next((
                    p for p in teachers
                    if p.id_teacher not in [supervisor.id_teacher, president.id_teacher]
                    and p.availability[day_index][slot_index] is True
                    and student.speciality in p.speciality
                    and (len(p.daily_counter) <= day_index or p.daily_counter[day_index] < max_defenses_per_day)
                ), None)

                if examiner is None:
                    continue

                # OK, on peut créer la soutenance
                # Calculer la date en fonction de day_index
                defense_date = date_debut + timedelta(days=day_index)
                slot_time = f"Slot_{slot_index+1}"

                # Créer un Jury
                jur = Jury(
                    president_id=president.id_teacher,
                    supervisor_id=supervisor.id_teacher,
                    examiner_id=examiner.id_teacher
                )
                jury_list.append(jur)

                # Créer une Defense
                defense = Defenses(
                    student_id=student.id_student,
                    id_jury=jur.id_jury,
                    id_room=candidate_room.id_room,
                    defense_date=defense_date,
                    slot_time=slot_time
                )
                defenses_list.append(defense)

                # Bloquer le slot
                supervisor.availability[day_index][slot_index] = False
                candidate_room.room_availability[day_index][slot_index] = False
                president.availability[day_index][slot_index] = False
                examiner.availability[day_index][slot_index] = False

                # Incrémente le nb_defenses + daily_counter
                supervisor.nb_defenses += 1
                president.nb_defenses += 1
                examiner.nb_defenses += 1
                if len(supervisor.daily_counter) <= day_index:
                    supervisor.daily_counter.append(1)
                else:
                    supervisor.daily_counter[day_index] += 1

                if len(president.daily_counter) <= day_index:
                    president.daily_counter.append(1)
                else:
                    president.daily_counter[day_index] += 1

                if len(examiner.daily_counter) <= day_index:
                    examiner.daily_counter.append(1)
                else:
                    examiner.daily_counter[day_index] += 1

                # On considère l'étudiant comme planifié => break
                assigned = True
                break  # slot_index

            if assigned:
                break  # day_index

    return (defenses_list, jury_list)


"""
------------------------------------------------------------------------------
         4) Fonction PRINCIPALE pour l’heuristique 2
------------------------------------------------------------------------------
"""

def main_heuristique2(
    df_teacher,
    df_room,
    df_student,
    df_availavilityTeacher,
    df_availavilityRoom,
    horaires_ids,
    date_debut,
    date_fin,
    df_specialites,
    max_defenses_per_day=4
):
    """
    1) Charger les données EXACTEMENT comme H1 via charger_donnees
    2) Appliquer la logique de génération "H2" via build_schedule_h2
    3) Retourner la liste des soutenances + jurys
    """
    # Étape 1 : Chargement
    teachers, rooms, students = charger_donnees(
        df_teacher,
        df_room,
        df_student,
        df_availavilityTeacher,
        df_availavilityRoom,
        horaires_ids,
        date_debut,
        date_fin,
        df_specialites
    )

    # Étape 2 : Génération (logique H2)
    defenses_list, jury_list = build_schedule_h2(
        teachers=teachers,
        rooms=rooms,
        students=students,
        date_debut=date_debut,
        max_defenses_per_day=max_defenses_per_day
    )

    # On peut formater le résultat
    data_defenses = []
    for d in defenses_list:
        data_defenses.append({
            "id_defense": d.id_defense,
            "student_id": d.student_id,
            "jury_id": d.id_jury,
            "room_id": d.id_room,
            "defense_date": d.defense_date.strftime("%Y-%m-%d"),
            "slot_time": d.slot_time
        })

    data_jurys = []
    for j in jury_list:
        data_jurys.append({
            "id_jury": j.id_jury,
            "president_id": j.president_id,
            "supervisor_id": j.supervisor_id,
            "examiner_id": j.examiner_id
        })

    return {
        "defenses": data_defenses,
        "jury": data_jurys
    }


"""
------------------------------------------------------------------------------
          5) (Optionnel) Métriques façon H2
------------------------------------------------------------------------------
"""
def calculate_metrics_h2(teachers):
    """
    Calcule quelques stats sur le nombre de soutenances par enseignant.
    """
    nb_soutenances = [t.nb_defenses for t in teachers]
    total = sum(nb_soutenances)
    if len(nb_soutenances) <= 1:
        mean_val = nb_soutenances[0] if nb_soutenances else 0
        stdev_val = 0
    else:
        mean_val = statistics.mean(nb_soutenances)
        stdev_val = statistics.stdev(nb_soutenances)
    return {
        "total_defenses": total,
        "mean_defenses": mean_val,
        "stdev_defenses": stdev_val
    }
