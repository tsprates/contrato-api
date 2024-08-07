FROM ubuntu:22.04

WORKDIR /app

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y \
    python3 \
    python3-pip \
    curl \
    zip \
    tesseract-ocr \
    libtesseract-dev \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y \
    php8.3 \
    php8.3-xml \
    php8.3-mysql \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pip install pytesseract

RUN curl -L -o /usr/share/tesseract-ocr/4.00/tessdata/por.traineddata https://github.com/tesseract-ocr/tessdata/raw/main/por.traineddata

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public/"]
