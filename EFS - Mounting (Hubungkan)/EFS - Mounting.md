```bash
#Lakukan di masing-masing EC2 (Server 1 dan Server 2):
sudo dnf install -y amazon-efs-utils
sudo mkdir -p /DataFile
sudo mount -t efs -o tls fs-xxxxxxxx:/ /DataFile

#Test EFS Sharing Di EC2 Server 1:
echo "Test EFS dari Server 1" | sudo tee /DataFile/test-efs.txt

#Di EC2 Server 2:
cat /DataFile/test-efs.txt
#Jika muncul Test EFS dari Server 1, berarti EFS berhasil ter-mount dan share antar server
```