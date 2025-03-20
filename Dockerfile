FROM php:8.3-cli

WORKDIR /app

COPY . /app

RUN apt-get update && \
    apt-get install -y sox libsox-fmt-mp3 libsox-fmt-base && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
