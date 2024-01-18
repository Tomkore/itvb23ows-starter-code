# Gebruik het officiële PHP image
FROM php:7.3-cli
RUN docker-php-ext-install mysqli
# Kopieer de broncode van je app naar de container
COPY . ./

# Stel de werkdirectory in
WORKDIR ./

# Stel de poort in die de container zal gebruiken
EXPOSE 8000

# Start de PHP ingebouwde server
CMD [ "php", "-S", "0.0.0.0:8000" ]

