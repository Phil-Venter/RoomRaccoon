# RoomRaccoon

A simple as far as possible MVC framework

## controllers

Controllers orchestrating the Models and View data.

### ErrorController

Controller that handles the displaying of error pages.

## Models

Database interactions.

## Public

Directory visible to the public, serve this so none of your application gets leaked to the public.

### .htaccess

Apache rules, that allow the system to opperate.

### index.php

Entrypoint of the application, also contains all the routes, and router execute function.

## System

Under-the-hood files containing the core files.

### DB

Class that instanciates the PDO connection.

### Model

Contains the main PDO interaction methods.

### Request

Request contains get, post and args (from the router)

### Response

Class abstacting away the browser response functionality

### Router

Class managaing which path goes to which endpoint

### Template

Simple tempating engine

## Views

Contains the views that will be returned to the end-user

## root

Main directory

### bootstrap

File loading the config and classes, instantiating the Template engine, request and response objects, and finally instantiating the DB and Router.

### dist-config (config)

Example config file with all sensitive data removed.
