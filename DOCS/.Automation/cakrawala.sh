#!/bin/bash

# Fungsi untuk menampilkan bantuan
show_help() {
  echo "Usage: $0 [option]"
  echo "Options:"
  echo "1. run       - Jalankan Server Installer"
  echo "2. help      - Tampilkan bantuan"
  echo "3. info      - Tampilkan informasi skrip"
  echo "4. changelog - Tampilkan changelog"
  echo "0. exit      - Keluar dari skrip"
  read -p "Masukkan pilihan Anda (1/2/3/4/0): " choice
  case $choice in
    1) run_installer ;;
    2) show_help ;;
    3) script_info ;;
    4) changelog ;;
    0) exit ;;
    *) echo "Pilihan tidak valid"; show_help ;;
  esac
}

run_installer() {
  echo "========================================================================="
  echo "Pilih Environment"
  echo "========================================================================="
  echo "1. Local Server"
  echo "2. Cloud Server"
  echo "0. Kembali"
  read -p "Masukkan pilihan Anda (1/2/0): " env_choice
  case $env_choice in
    1) local_install ;;
    2) cloud_install ;;
    0) show_help ;;
    *) echo "Pilihan tidak valid"; run_installer ;;
  esac
}

# Fungsi untuk menampilkan informasi skrip
script_info() {
  # Informasi Installer
  echo "========================================================================="
  echo "Gabut Installer - Versi 1.0.69"
  echo "Author: DevGabut"
  echo "email: teamgaboed@gmail.com"
  echo "Deskripsi: Skrip ini akan menginstal dan mengkonfigurasi berbagai"
  echo "komponen seperti aapanel, Nginx, MySQL, PHP, Docker, ser2net, dan openais."
  echo "========================================================================="
  echo "0. Kembali"
  read -p "Masukkan pilihan Anda (0): " back_choice
  case $back_choice in
    0) show_help ;;
    *) show_help ;;
  esac
}

# Fungsi untuk menampilkan changelog
changelog() {
  echo "========================================================================="
  echo "Changelog"
  echo "========================================================================="
  echo "1.0.69: "
  echo "  - Perbaikan pada fungsi expect"
  echo "  - Menambahkan instalasi openssh"
  echo "  - Menambahkan ekstensi fileinfo, bzip, zip, exif"
  echo "  - Menghapus putenv dan exec dari fungsi disable"
}

# Fungsi untuk menginstal Expect
install_expect() {
  echo "========================================================================="
  echo "Install Expect"
  echo "========================================================================="
  apt update && apt install -y expect || echo "Failed to install expect"
}

# Fungsi untuk menginstal OpenSSH
install_openssh() {
  echo "========================================================================="
  echo "Mengunduh dan menginstal openssh"
  echo "========================================================================="
  apt update && apt install -y openssh || echo "Failed to install openssh"
}

# Fungsi untuk menginstal AAPanel
install_aapanel() {
  echo "========================================================================="
  echo "Mengunduh dan menginstal aapanel"
  echo "========================================================================="
  URL=https://www.aapanel.com/script/install_7.0_en.sh && if [ -f /usr/bin/curl ];then curl -ksSO "$URL" ;else wget --no-check-certificate -O install_7.0_en.sh "$URL";fi;yes | bash install_7.0_en.sh aapanel || echo "Failed to install aapanel"
}

# Fungsi untuk mengatur password AAPanel
set_aapanel_password() {
  echo "========================================================================="
  echo "Mengatur password baru untuk aapanel"
  echo "========================================================================="
  expect << EOF
spawn bt 5
expect "Pls enter new password:"
send "appDEV1234\r"
expect eof
EOF
}

# Fungsi untuk mengatur username AAPanel
set_aapanel_username() {
  echo "========================================================================="
  echo "Mengatur username baru untuk aapanel"
  echo "========================================================================="
  expect << EOF
spawn bt 6
expect "Pls enter new username(>5 characters):"
send "appdev\r"
expect eof
EOF
}

# Fungsi untuk mengatur port AAPanel
set_aapanel_port() {
  echo "========================================================================="
  echo "Mengatur port panel baru untuk aapanel"
  echo "========================================================================="
  expect << EOF
spawn bt 8
expect "Pls enter new panel port:"
send "14045\r"
expect eof
EOF
}

# Fungsi untuk mengatur security entrance AAPanel
set_aapanel_security() {
  echo "========================================================================="
  echo "Mengatur security entrance panel baru untuk aapanel"
  echo "========================================================================="
  expect << EOF
spawn bt 28
expect "Please enter new security entrance:"
send "/pernikaverse\r"
expect eof
EOF
}

# Fungsi untuk menginstal Nginx
install_nginx() {
  echo "========================================================================="
  echo "Menginstal Nginx"
  echo "========================================================================="
  /bin/bash /www/server/panel/install/install_soft.sh 0 install nginx 1.24 || echo "Failed to install Nginx"
}

# Fungsi untuk menginstal MySQL
install_mysql() {
  echo "========================================================================="
  echo "Menginstal MySQL"
  echo "========================================================================="
  /bin/bash /www/server/panel/install/install_soft.sh 0 install mysql 8.4 || echo "Failed to install MySQL"
}

# Fungsi untuk menginstal PHP
install_php() {
  echo "========================================================================="
  echo "Menginstal PHP"
  echo "========================================================================="
  /bin/bash /www/server/panel/install/install_soft.sh 0 install php 8.3 || echo "Failed to install PHP"
}

# Fungsi untuk menginstal ekstensi PHP
install_php_extensions() {
  echo "========================================================================="
  echo "Menginstal ekstensi fileinfo untuk PHP"
  echo "========================================================================="
  /www/server/php/83/bin/php -m | grep -q 'fileinfo' || /www/server/php/83/bin/pecl install fileinfo || echo "Failed to install fileinfo extension"
  /www/server/php/83/bin/php -m | grep -q 'bzip' || /www/server/php/83/bin/pecl install bzip || echo "Failed to install bzip extension"
  /www/server/php/83/bin/php -m | grep -q 'zip' || /www/server/php/83/bin/pecl install zip || echo "Failed to install zip extension"
  /www/server/php/83/bin/php -m | grep -q 'exif' || /www/server/php/83/bin/pecl install exif || echo "Failed to install exif extension"
}

# Fungsi untuk menghapus putenv dan exec dari fungsi disable
remove_disable_functions() {
  echo "========================================================================="
  echo "Menghapus putenv dan exec dari fungsi disable"
  echo "========================================================================="
  sed -i 's/disable_functions = .*putenv,//' /www/server/php/82/etc/php.ini || echo "Failed to remove putenv from disable functions"
  sed -i 's/disable_functions = .*exec,//' /www/server/php/82/etc/php.ini || echo "Failed to remove exec from disable functions"
}

# Fungsi untuk menginstal PHPMyAdmin
install_phpmyadmin() {
  echo "========================================================================="
  echo "Menginstal PHPMyAdmin"
  echo "========================================================================="
  /bin/bash /www/server/panel/install/install_soft.sh 0 install phpmyadmin latest || echo "Failed to install PHPMyAdmin"
}

# Fungsi untuk menginstal Docker
install_docker() {
  echo "========================================================================="
  echo "Menginstal Docker"
  echo "========================================================================="
  /bin/bash /www/server/panel/install/install_soft.sh 0 install docker_install || echo "Failed to install Docker"
}

# Fungsi untuk menginstal ser2net
install_ser2net() {
  echo "========================================================================="
  echo "Menginstal ser2net"
  echo "========================================================================="
  apt-get install -y ser2net || echo "Failed to install ser2net"
}

# Fungsi untuk mengkonfigurasi ser2net
configure_ser2net() {
  echo "========================================================================="
  echo "Mengkonfigurasi ser2net"
  echo "========================================================================="
  mv /etc/ser2net.yaml /etc/ser2net.yaml.bak
  touch /etc/ser2net.yaml
  cat <<EOT >> /etc/ser2net.yaml
connection: &con0384
    accepter: tcp,5005
    enable: on
    options:
      banner: *banner
      kickolduser: true
      telnet-brk-on-sync: true
    connector: serialdev,
              /dev/ttyS0,
              38400n81,local
EOT
  systemctl restart ser2net || echo "Failed to restart ser2net"
}

# Fungsi untuk menginstal openais
install_openais() {
  echo "========================================================================="
  echo "Mengunduh dan menginstal openais"
  echo "========================================================================="
  cd /www/wwwroot/ && mkdir openais && cd openais && git clone https://github.com/abewartech/openais.git . || echo "Failed to install openais"
  echo "============================="
  echo "Mengatur .env"
  echo "============================="
  cp .env.example .env
  sed -i 's/^SOURCE_HOST=.*/SOURCE_HOST=0.0.0.0/' .env
  sed -i 's/^SOURCE_PORT=.*/SOURCE_PORT=5005/' .env || echo "Failed to configure .env"
  echo "============================="
  echo "Pull Open-AIS Docker Image"
  echo "============================="
  docker compose pull || echo "Failed to pull Open-AIS Docker image"
  echo "============================="
  echo "Setup Open-AIS Docker Volume"
  echo "============================="
  docker volume create db_data_store || echo "Failed to create Docker volume"
  echo "============================="
  echo "Starting Docker"
  echo "============================="
  docker compose up -d || echo "Failed to start Docker"
}

# Fungsi untuk menjalankan Restreamer
run_restreamer() {
  echo "========================================================================="
  echo "Menjalankan Restreamer"
  echo "========================================================================="
  docker run -d --restart=always --name restreamer \
     -v /opt/restreamer/config:/core/config -v /opt/restreamer/data:/core/data \
     -p 8080:8080 -p 8181:8181 \
     -p 1935:1935 -p 1936:1936 \
     -p 6000:6000/udp \
     datarhei/restreamer:latest || echo "Failed to run Restreamer"
}

# Fungsi untuk menjalankan SignalK
run_signalk() {
  echo "========================================================================="
  echo "Menjalankan SignalK"
  echo "========================================================================="
  docker run -d --init --name signalk-server -p 3000:3000 -v $(pwd):/home/node/.signalk cr.signalk.io/signalk/signalk-server
}

# Fungsi untuk menginstal Node.js
install_nodejs() {
  echo "========================================================================="
  echo "Menginstal Node.js"
  echo "========================================================================="
  curl -fsSL https://deb.nodesource.com/setup_18.x -o nodesource_setup.sh
  sudo -E bash nodesource_setup.sh
  sudo apt-get install -y nodejs || echo "Failed to install Node.js"
}

#Fungsi untuk update npm
update_npm() {
  echo "========================================================================="
  echo "Mengupdate npm"
  echo "========================================================================="
  sudo npm install -g npm@latest || echo "Failed to update npm"
}

# Fungsi untuk menginstal PM2
install_pm2() {
  echo "========================================================================="
  echo "Menginstal PM2"
  echo "========================================================================="
  sudo npm install -g pm2 || echo "Failed to install PM2"
}

# Fungsi untuk menginstal Node-RED
install_nodered() {
  echo "========================================================================="
  echo "Menginstal Node-RED"
  echo "========================================================================="
  sudo npm install -g --unsafe-perm node-red || echo "Failed to install Node-RED"
}

# Fungsi untuk menginstal BUN
install_bun() {
  echo "========================================================================="
  echo "Menginstal BUN"
  echo "========================================================================="
  curl -fsSL https://bun.sh/install | bash
}

# Fungsi untuk menginstal OBS Studio
install_obs() {
  echo "========================================================================="
  echo "Menginstal OBS Studio"
  echo "========================================================================="
  sudo add-apt-repository ppa:obsproject/obs-studio
  sudo apt update
  sudo apt install -y obs-studio || echo "Failed to install OBS Studio"
}

# Fungsi untuk menginstal source code
install_source_code() {
  echo "========================================================================="
  echo "Menginstal Source Code"
  echo "========================================================================="
  git config --global credential.helper store
  cd /www/wwwroot

  # Clone repositories with credentials
  git clone https://abewartech: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@github.com/abewartech/AIS-Local.git || echo "Failed to clone AIS-Local repository"
  git clone https://abewartech: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@github.com/abewartech/AIS-Local-Lumen.git || echo "Failed to clone AIS-Local-Lumen repository"
  git clone https://abewartech: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@github.com/abewartech/trackerFe.git || echo "Failed to clone trackerFe repository"
  git clone https://abewartech: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@github.com/abewartech/ais-bun.git || echo "Failed to clone ais-bun repository"
  git clone https://abewartech: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@github.com/abewartech/AIS-Local-Geofence.git || echo "Failed to clone AIS-Local-Geofence repository"

  # Install bun if not installed
  if ! command -v bun &> /dev/null; then
    echo "Bun is not installed. Installing bun..."
    curl -fsSL https://bun.sh/install | bash || echo "Failed to install bun"
  fi

  # Run bun install and composer install
  cd AIS-Local
  bun install || echo "Failed to run bun install in AIS-Local"
  composer install || echo "Failed to run composer install in AIS-Local"

  cd ../AIS-Local-Lumen
  bun install || echo "Failed to run bun install in AIS-Local-Lumen"
  composer install || echo "Failed to run composer install in AIS-Local-Lumen"

  cd ../trackerFe
  bun install || echo "Failed to run bun install in trackerFe"

  cd ../ais-bun
  bun install || echo "Failed to run bun install in ais-bun"

  cd ../AIS-Local-Geofence
  bun install || echo "Failed to run bun install in AIS-Local-Geofence"
  composer install || echo "Failed to run composer install in AIS-Local-Geofence"
}

local_install() {
  install_expect
  install_openssh
  install_aapanel
  set_aapanel_password
  set_aapanel_username
  set_aapanel_port
  set_aapanel_security
  install_nginx
  install_mysql
  install_php
  install_php_extensions
  remove_disable_functions
  install_phpmyadmin
  install_docker
  install_ser2net
  configure_ser2net
  install_openais
  run_restreamer
  run_signalk
  install_nodejs
  install_pm2
  install_nodered
  install_bun
  # install_obs
  install_source_code
  update_composer
}

cloud_install() {
  install_expect
  install_aapanel
  set_aapanel_password
  set_aapanel_username
  set_aapanel_port
  set_aapanel_security
  install_nginx
  install_mysql
  install_php
  install_php_extensions
  remove_disable_functions
  install_phpmyadmin
  install_docker
  install_openais
  run_restreamer
  run_signalk
  install_nodejs
  install_pm2
  install_nodered
  install_bun
  # install_obs
  install_source_code
  update_composer
}

# Deteksi apakah pengguna adalah root
if [ "$EUID" -ne 0 ]; then
  echo "Skrip ini harus dijalankan sebagai root. Meminta password sudo..."
  exec sudo -s "$0" "$@"
  exec sudo bash "$0" "$@"
  exit
fi

show_help

update_composer() {
  echo "========================================================================="
  echo "Updating Composer"
  echo "========================================================================="
  composer self-update || echo "Failed to update Composer"
}
