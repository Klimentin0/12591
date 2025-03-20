# Use an official PHP image as the base
FROM php:8.3-cli

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Install SoX
RUN apt-get update && \
    apt-get install -y sox libsox-fmt-mp3 && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
