FROM node:22-alpine

WORKDIR /var/www

COPY ./panel/package*.json ./

RUN npm install

COPY ./panel .

COPY panel/docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && chown -R node:node /var/www

# USER node

EXPOSE 5173

ENTRYPOINT ["entrypoint.sh"]

CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]