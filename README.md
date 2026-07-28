
# Traffic Tracker
  
Welcome to the project Traffic Tracker, a platform made to track websites, e-commerce, and web platforms.
   
### Setup Project
After cloning the repository, run the command below:

    docker compose up -d

All services will run; the database schema will be created automatically at the end of the MySQL container finishing initialization.
    
### Logs

    docker compose logs -f
If you'd like to see a specific log container, just run:

    docker compose logs [name_container] -f

