## What is LoingAPI?
It all started with a simple project to study about some topics:

 - POO;
 - CRUD;
 - SOLID;
 - Object calisthenics.
 

Making the content get from different sides of the internet (like Alura, Youtube, Discord and others) into real projects, but with this study-apply cycle, I was concerned about the real job market of backend develop and how I should model my projects to real world applications. Thinking about all of this, I decided to drastically change the Loing, getting it from a simple video and email streamer to an **API** wich anyone can use in a simple and escalable way. With everything set, let's get to work on the endploints.

> To demonstrate more of my skills as I possibly can, LoingTube, a front-end to consume the LoingAPI, is coming sooner.

## Endpoints table

| Endpoint | HTTP method | body |
|----------|-------------|----|
|`/acess/login` | GET |  	  |
|`/acess/signup`| PUT | Nickname, email, password| 
|`/acess/logout`| GET | No   |
|`/videos/search?{query}`| GET | No |
|`/videos/search/{id}`| GET | No |
| `/videos/publish`| POST | Title, content |
| `/mail/inbox`| GET | No |
| `/mail/send`| POST | Reciever, date, text   |

