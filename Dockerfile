FROM centos:centos7
RUN yum update -y
RUN yum install epel-release -y
RUN yum install git python-setuptools -y
RUN yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm
RUN yum-config-manager --enable remi-php83
RUN yum install -y php php-common 
EXPOSE 443
WORKDIR /usr/src/zenpacklab
COPY . .
RUN git clone https://github.com/linkslice/CustomScriptBuilder.git
CMD [" php -S 0.0.0.0:443"]
