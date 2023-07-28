import os
import subprocess
import schedule
import time

repository_path = r'C:\Users\USER\Documents\AIS-Local'

def git_pull():
    try:
        # Change the current working directory to the repository path
        os.chdir(repository_path)

        # Execute the Git pull command using subprocess
        subprocess.check_output(['git', 'pull'])
        print('Git pull successful!')

    except subprocess.CalledProcessError as e:
        print('Error during Git pull:', e)

# Perform the initial Git pull
git_pull()

# Schedule periodic Git pulls every 10 minutes
schedule.every(10).minutes.do(git_pull)

# Keep the script running
while True:
    schedule.run_pending()
    time.sleep(1)
