```bash
# SSH ke Instance EC2
# (Bisa menggunakan CMD yang diarahkan ke "keypair.pem" biasanya di direktori Downloads)
# (C:\Users\"NamaUser"\Downloads>)
# ssh -i lokasi_file_pem ec2-user@ec2-instance-public-dns-name

-------------------------------------------------------------------------------------------------------------------------------------------

## Setup RDS MariaDB & MySQL (2024) ##

# Update sistem
sudo dnf update -y

# Instalasi Apache, PHP, dan MariaDB client
sudo dnf install -y httpd php php-mysqli mariadb105

# Cek versi sistem
cat /etc/system-release

# Jalankan dan aktifkan layanan Apache
sudo systemctl start httpd
sudo systemctl enable httpd

# Tambahkan ec2-user ke grup apache
sudo usermod -a -G apache ec2-user
exit
#exit untuk merefresh lalu kembali lagi ke SSH EC2

# Cek grup pengguna
groups
# Output yang diharapkan:
# ec2-user adm wheel apache systemd-journal

# Atur izin direktori /var/www
sudo chown -R ec2-user:apache /var/www
sudo chmod 2775 /var/www
find /var/www -type d -exec sudo chmod 2775 {} \;
find /var/www -type f -exec sudo chmod 0664 {} \;

# Buat folder konfigurasi database dan file konfigurasi
cd /var/www
mkdir inc
cd inc
nano koneksi.inc

#[link koneksi.inc: klik file koneksi.inc sebelah kiri]

# Buat file aplikasi PHP contoh
cd /var/www/html
nano index#1.php 

#[link index#1.php: klik file index#1.php sebelah kiri]
```

