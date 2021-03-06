# sary-app-laravel

[![ci-cd](https://github.com/iabdulrahman91/sary-app-laravel/actions/workflows/ci-cd.yaml/badge.svg)](https://github.com/iabdulrahman91/sary-app-laravel/actions/workflows/ci-cd.yaml)

---
## APP URL


**main api**
[API URL] (http://a7fb6ec99dd5e44639b36cef3699092f-feb52c773df7eb64.elb.us-east-2.amazonaws.com/api)

**questions**

[Main URL] (http://a7fb6ec99dd5e44639b36cef3699092f-feb52c773df7eb64.elb.us-east-2.amazonaws.com/api/questions)

**You can use the provided `Postman` config file To TEST the API**

`Postman > File menu > Import`

see `postman/`

---

This Repo is to Demonstrate my ability to:

- Build RESTful API using Laravel PHP

- Setup CI/CD pipeline using GitHub Actions

- Dockerizing Laravel App

- Setup Development Environment using docker-compose

- Test-Driven Development (TDD)

---

## APP: Stackoverflow clone

### Models and relationship

Question:

- Can have many Answers (one to many)
- Belong to many Tags (many to many)
- Can have many Comments (One To Many (Polymorphic))

Answer:

- Belong to a Question (one to many)
- Can have many Comments (One To Many (Polymorphic))

Tag:

- Belong to many Qusitons (many to many)

Comment:

- Belong to a Commentable (such as Question or Answer)  (One To Many (Polymorphic))

---

## CI/CD

Use GitHub Actions to:

- Build the app

- Test the app using PHPUnit

- Containerize the app

- Push the Docker Image to Docker Hub

---

## docker-compose

Utilize laravel/sail package to use docker-compose (app + database)

---

## TDD

Follow Test-Driven Development process to assure quility and continiuos integration
