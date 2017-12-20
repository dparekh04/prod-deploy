echo "Unzipping Package... ;)"
# Getting current package Number
package="$1"
mkdir $HOME/packaging/temp/
mkdir $HOME/Desktop/dhruvAPIServer

tar -xzf $HOME/packaging/$package -C $HOME/packaging/temp/
echo "Installing API.. how exciting -_-"
	cp -a -v $HOME/packaging/temp/* $HOME/Desktop/dhruvAPIServer/
echo "Adjusting RabbitMQ .ini..."
	sed -i '2s/.*/BROKER_HOST = 192.168.1.32/g' $HOME/Desktop/dhruvAPIServer/apiRabbitMQ.ini
echo "API Package Sucessfully Installed!"

