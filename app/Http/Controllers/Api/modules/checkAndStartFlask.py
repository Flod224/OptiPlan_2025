import subprocess
import psutil
import time

# Vérifier si Flask est déjà en cours d'exécution
def is_flask_running():
    for proc in psutil.process_iter(attrs=['pid', 'name', 'connections']):
        for conn in proc.info['connections']:
            if conn.laddr.port == 5000:  # Port par défaut de Flask
                return True
    return False
import os

# Démarrer Flask si nécessaire
def start_flask():
    if not is_flask_running():
        print("Flask n'est pas démarré. Démarrage en cours...")
        script_path = "C:/Users/mammo/OneDrive - UMONS/Documents/MA1/Q1/Projet et dev num/Projet/OptiPlan/DefenseSchedulerIFRI/DefenseSchedulerIFRI-optimaid/app/Http/Controllers/Api/flask_api.py"

        os.environ["FLASK_APP"] = script_path  # Indique où se trouve l'application
        os.environ["FLASK_ENV"] = "development"  # Active le mode debug

        process = subprocess.Popen(
            ["C:/Users/mammo/AppData/Local/Programs/Python/Python312/python.exe", "-m", "flask", "run", "--host=127.0.0.1", "--port=5000",],
            stdout=subprocess.PIPE,
            stderr=subprocess.PIPE
        )
      


        stdout, stderr = process.communicate()
        
        # Affichez les logs pour déboguer
        if stdout:
            print("STDOUT:", stdout.decode())
        if stderr:
            print("STDERR:", stderr.decode())

        time.sleep(5)  # Attendre que Flask démarre
        if is_flask_running():
            print("Flask a démarré avec succès.")
        else:
            print("Échec du démarrage de Flask.")
    else:
        print("Flask est déjà en cours d'exécution.")


if __name__ == "__main__":
    start_flask()
