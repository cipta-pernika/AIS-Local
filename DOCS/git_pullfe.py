import os
import subprocess
import schedule
import time

repository_path = r'C:\Users\USER\Documents\trackerFe'
yarn_path = r'C:\Users\USER\AppData\Roaming\npm\node_modules\yarn\bin\yarn.cmd'  # Replace with the actual path to the yarn executable

def git_pull():
    try:
        # Change the current working directory to the repository path
        os.chdir(repository_path)

        # Execute the Git pull command using subprocess
        subprocess.check_output(['git', 'pull'])
        print('Git pull successful!')

        # Execute the yarn install command using subprocess
        subprocess.check_output([yarn_path, 'install'])
        print('Yarn install successful!')

    except subprocess.CalledProcessError as e:
        print('Error during Git pull or Yarn install:', e)

# Perform the initial Git pull and Yarn install
git_pull()

# Schedule periodic Git pulls and Yarn installs every 10 minutes
# schedule.every(10).minutes.do(git_pull)

# # Keep the script running and print the timestamp for each scheduled run
# while True:
#     schedule.run_pending()
#     print('Scheduled job executed at:', time.strftime('%Y-%m-%d %H:%M:%S'))
#     time.sleep(60)
