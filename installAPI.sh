echo "Extracting files....."
# Getting current package Number
package="$1"
mkdir $HOME/packaging/temp/
mkdir $HOME/Desktop/dhruvAPIServer

tar -xzf $HOME/packaging/$package -C $HOME/packaging/temp/
echo "Unzipping API Files..."
	cp -a -v $HOME/packaging/temp/* $HOME/Desktop/dhruvAPIServer/
echo "Changing .ini files...."
	sed -i '2s/.*/BROKER_HOST = 192.168.1.32/g' $HOME/Desktop/dhruvAPIServer/apiRabbitMQ.ini
echo "------DONE------"

