FROM node:16.15-alpine

WORKDIR /app

# RUN apk update && \
#     apk add git && \
#     apk add --no-cache curl && \
#     curl -o- -L https://yarnpkg.com/install.sh | sh

# RUN mkdir src

RUN apk update && \
    apk upgrade && \
    apk add git && \
    npm install -g npm@latest nuxi nuxt3

ENV TZ Asia/Tokyo
# ENV PATH $HOME/.yarn/bin:$HOME/.config/yarn/global/node_modules/.bin:$PATH

# CMD ["/bin/ash"]
