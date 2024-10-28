
**LaraClean: A Laravel Package for Domain-Driven Design**
===========================================================

**Description**
---------------

LaraClean is a Laravel package designed to facilitate domain-driven design (DDD) principles in your application. It provides a set of console commands to help you create and manage your domain models, DTOs, and migrations in a structured and organized way.

**Usage**
-----

### Installation

To install LaraClean, run the following command in your terminal:
```bash
composer require rlimjr/lara-clean
```
### Available Commands

LaraClean provides the following console commands:

* `make:domain`: Create a new domain model
* `make:domain-dto`: Create a new DTO (Data Transfer Object)
* `make:domain-migration`: Create a new migration for a domain model

### Command Options

* `--domain`: Specify the domain name (required)
* `--name`: Specify the model or DTO name (required)
* `--path`: Specify the path to the domain directory (optional)

### Examples

* Create a new domain model:
```bash
php artisan make:domain Question
```
* Create a new DTO:
```bash
php artisan make:dto Question Question
```
* Create a new migration for a domain model:
```bash
php artisan make:domain-migration Question Choices<optional>
```
### Directory Structure

LaraClean assumes the following directory structure for your domain models and DTOs:
```bash
app/
Domain/
{domain-name}/
Models/
{model-name}.php
DTOs/
{dto-name}.php
Migrations/
{migration-name}.php
```