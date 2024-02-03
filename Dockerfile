FROM mariadb:latest

# Set environment variables
ENV MYSQL_DATABASE=informatikhighscores
ENV MYSQL_ROOT_PASSWORD=8hHLM6y#2UqJ6N

# Copy the database initialization script to the init directory
COPY ./docker-entrypoint-initdb.d /docker-entrypoint-initdb.d

# Expose port
EXPOSE 3306