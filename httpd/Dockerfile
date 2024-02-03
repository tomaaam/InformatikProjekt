# Use the official HTTPD image as the base image
FROM httpd:2.4

# Set the working directory
WORKDIR /usr/local/apache2/htdocs

# Enable necessary Apache modules
RUN sed -i '/#LoadModule cgi_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i '/#LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i '/#LoadModule proxy_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i '/#LoadModule proxy_fcgi_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i '/#LoadModule vhost_alias_module/s/^#//g' /usr/local/apache2/conf/httpd.conf

# Configure Apache to use PHP-FPM
RUN echo "ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://php-apache:9000/usr/local/apache2/htdocs/$1" >> /usr/local/apache2/conf/httpd.conf

# Expose port 80
EXPOSE 80
