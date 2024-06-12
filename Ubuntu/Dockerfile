FROM ubuntu:22.04
RUN apt update
RUN DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt-get -y install php php-common git python2.7 python-setuptools
RUN update-alternatives --install /usr/bin/python python /usr/bin/python2 2
EXPOSE 42069
WORKDIR /usr/src/zenpacklab
COPY . .
RUN git clone https://github.com/linkslice/CustomScriptBuilder.git
ENTRYPOINT ["/bin/sh", "/usr/src/zenpacklab/phpstart.sh"]
