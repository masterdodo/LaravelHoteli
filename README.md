# Hotel Manager
This project allows you to insert hotels to the database. It allows you to edit them or delte them if you are the publisher of that hotel. 
<br><br>
### Kazalo:
[Login and Register](#login-and-register)<br>
[Administrator](#administrator)<br>
[Uporabniki](#uporabniki)<br>
[Upravljanje hotelov](#upravljanje-hotelov)<br>
## Login and Register
### 1. Register
You can register in two ways:<br>
- through built-in Auth system in Laravel
- through Google API (with your Google account)
### 2. Login
You can login in two different ways:<br>
- through Laravel Auth system that is built-in
- through Google API that saves your data if you previously logged in and creates new account if it's your first time. 

## Administrator
Administrator is a user that has all the permissions.<br>
His function is to manage hotels and users of the web applications.<br>
He has options to:<br>
- Create publishers (inputs all the data)
- Delete publishers (this functions also deletes all of his hotels)
- Add regular user(works like the user signup)
- Add hotels
- Edit hotels
- Delete hotels

## Users
All users that create their account can apply for a hotel and can choose how many people they want to apply. They can change their username or password in the Edit profile page.
### 1. Publishers
Publisher can:<br>
- Add new hotels
- Edit their hotels (their own)
- Delete their hotels (their own)
### 2. Normal users
Normal users are the ones that login/signup through regular Auth Laravel system.<br>
They don't have any special rights:<br>
- Apply to hotels that are available

## Managing hotels
With managing hotels there are three functions:
- Adding
- Editing
- Deleting
<br>
It shows us a form with all the attributes, we write them/edit them and then it saves them to the database. <br>

### App Screenshot:

![APP-IMAGE](https://raw.aristovnik.com/images/laravelhotel.png)
