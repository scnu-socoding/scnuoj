# 使用php8.1-fpm-alpine作为基础镜像
FROM php:8.1-fpm-alpine

# 设置apk源为国内镜像源，并安装tzdata和curl
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories \
    && apk add --no-cache tzdata curl build-base zip

# 设置时区为Asia/Shanghai
ENV TZ "Asia/Shanghai"
RUN cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo "Asia/Shanghai" > /etc/timezone

# 添加用户
RUN addgroup -g 1000 -S www && adduser -s /sbin/nologin -S -D -u 1000 -G www www

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# 安装php扩展
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd imagick opcache pdo_mysql mysqli pcntl zip

# 安装Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 设置Composer镜像源
RUN composer config -g repos.packagist composer https://packagist.mirrors.sjtug.sjtu.edu.cn

# 设置工作目录
WORKDIR /var/composer

# 将composer.json和composer.lock复制到工作目录
COPY composer.json .
COPY composer.lock .
COPY patches ./patches

# 安装项目依赖
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install

# 拷贝配置文件
COPY  /conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/^upload_max_filesize = .*/upload_max_filesize = 100M/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/^post_max_size = .*/post_max_size = 200M/' "$PHP_INI_DIR/php.ini"

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/error.log

WORKDIR /var/www/html
CMD ["sh", "-c","cp -fr /var/composer/vendor /var/www/html && php-fpm"]
