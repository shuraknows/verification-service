FROM gotify/server:latest


RUN mkdir -p /app/data
COPY ./docker/gotify/data/* /app/data

ENTRYPOINT ["./gotify-app"]