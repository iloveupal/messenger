#Messenger backend

##api

###users 

```HTTP
/users/register
@param string username
@param string pass

/users/delete
@auth
* not implemented yet
```

###profile 

```HTTP
/profile/view
@param int id

/profile/edit
@auth
@param string first_name?
@param string last_name?

/profile/get-profile-image
@param int id?
@param string image?

/profile/set-profile-image
@auth
@param file profile_image 
```

###messages

```HTTP
/messages/send
@auth
@param int to
@param string text

/messages/latest
@auth
@param int to
@param int count

/messages/from
@auth
@param int id
@param int count
```

###dialogues

```HTTP
/dialogues/all
@auth
@param int limit?
```

###auth
```HTTP
/auth/login
@param string username
@param string pass

/auth/request-magic-link
@param int id

/auth/magic
@param string token
```

###attachments
```HTTP
/attachments/uploads
@auth
@params file *

/attachments/get
@auth
@param string filename
```