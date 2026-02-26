Car Rental Platform Backend
Production-style backend system built with Laravel demonstrating scalable API architecture, domain-driven design principles, and real-world business workflows.
Overview

A robust backend service powering a scalable car rental platform, designed to deliver API-first, branch-aware car reservation and fleet management for business-grade deployments. The system seamlessly integrates multi-branch car management, real-time booking, and secure customer operations, supporting both administrative and client-facing workflows through clean RESTful interfaces.

Key Features

Comprehensive car rental workflow with bookings, car inventory, and branch management
Modular API endpoints supporting CRUD operations for bookings, cars, branches, and payment card details
Administrative and public endpoints with role-based separation
Secure authentication and session handling via Laravel Sanctum
Advanced search and nearest-branch discovery for customer experience optimization
Rate limiting and middleware orchestration for API integrity
System Architecture

This platform adheres to Laravel’s MVC paradigm with clear separation of concerns:

Controllers mediate API requests and orchestrate domain logic for bookings, cars, branches, and card details.
Models & Migrations (not shown) define normalized, relational schemas capturing cars, branches, and transactional entities.
API Layer exposes well-scoped RESTful endpoints for both administrative and customer-facing integrations, with middleware enforcing authentication and throttling.
Admin Subsystem leverages Laravel Admin to provide granular resource management for operational users.
Tech Stack

PHP 8.x
Laravel Framework (MVC, Eloquent, Sanctum)
MySQL (relational data store)
Composer (dependency management)
Laravel Admin (admin panel)
Docker-ready/12-factor friendly deployment
API Design

RESTful resource routes for core entities (bookings, cars, branches, card-details)
Namespaced endpoints and versionable API structure (/api)
Consistent CRUD semantics, with additional search and “nearest branch” geospatial querying
Standard and custom middleware stacks for authentication (auth:sanctum), rate limiting, and role scoping
Flexible, extendable endpoints facilitating rapid feature onboarding
Database Design

Normalized relational modeling for cars, bookings, and branches
Support for user and branch authentication/authorization and auditing
Scalable card detail storage adhering to PCI DSS considerations
Geographic data structures for branches to enable fast proximity queries
Performance & Scalability

API rate limiting (60 req/min/user or IP) to protect backend under heavy loads
Branch-specific authentication and routing for distributed multi-location support
Stateless JWT/session deployments, suited for cloud-native and horizontal scaling
Optimized for fast search and filtered listing operations at scale
Installation

bash
git clone https://github.com/sorarose99/client-car-rent-laravel.git
cd client-car-rent-laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
Environment Setup

PHP 8.x, Composer, MySQL server required
Configure .env with database credentials and other secrets
For local development:
php artisan serve
For API testing:
Use a REST client (Postman) with relevant Authorization headers
API Endpoints Overview

Resource	Endpoint	Methods	Description
Bookings	/api/bookings	GET, POST	List, create bookings
/api/bookings/{id}	GET, PUT, DELETE	View, update, delete booking
Cars	/api/cars	GET, POST	List, add cars
/api/cars/{car}	GET, PUT, DELETE	Car detail, update, delete
/api/cars/search	GET	Search cars
Branches	/api/branches	GET, POST	List, add branches
/api/branches/{id}	GET, PUT, DELETE	Branch detail, update, delete
/api/branches/nearest	GET	Geo-query for nearest branch
/api/branches/search	GET	Search branches
/api/branches/login-as-branch	POST	Branch login authentication
Card Details	/api/card-details	GET, POST	List, add card details
/api/card-details/{id}	GET, PUT, DELETE	Card detail, update, delete
Auth	/api/user	GET (auth)	Get authenticated user
Future Improvements

Integration of advanced search and dynamic pricing modules
Enhanced auditing and analytics endpoints
Extended branch/location management with external maps API
Event-driven notifications for bookings and branch operations
Full Docker/Kubernetes deployment support
Broader payment provider integrations (Stripe, PayPal, etc.)
Author

Developed and maintained by sorarose99
