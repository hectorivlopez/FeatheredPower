FROM mysql:5.7

# Copy the backup file to the container
COPY ./feathered_power_backup.mysql /home

# Set the environment variables for the MySQL root password and database name (you can customize this as needed)
ENV MYSQL_ROOT_PASSWORD=12
ENV MYSQL_DATABASE="feathered_power"