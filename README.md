# CRUD example

1. Build containers, install frontend and backend dependencies, configure app key, start containers:
    
    `make bootstrap`

2. When DB created, run the following command to apply migrations:

    `make run-backend-migrations`

3. Run tests:
    
    `run-backend-tests`
    
If you need testing data: `run-backend-seed`

Application available at: http://localhost:8001
