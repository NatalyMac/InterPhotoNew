define({ "api": [
  {
    "type": "post",
    "url": "/album-clients",
    "title": "Sets client access for album",
    "name": "Gives_access_to_the_Album",
    "group": "Album_Clients",
    "description": "<p>Gives access to the specific Album to the specific client Administrator, Photographer can give access</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "id",
            "description": "<p>Id album, Id client like { &quot;album_id&quot; : 16, &quot;user_id : 40}</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 201 Created": [
          {
            "group": "Success 201 Created",
            "type": "Json",
            "optional": false,
            "field": "Album",
            "description": "<p>the Album like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 201 Created\n Location:  http://127.0.0.1/interPhoto/web/albums/66\n    {\n\"album_id\": \"16\",\n\"user_id\": \"40\",\n \"id\": 3\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumClientsController.php",
    "groupTitle": "Album_Clients"
  },
  {
    "type": "post",
    "url": "/albums",
    "title": "Create new album",
    "name": "Create_Album",
    "group": "Albums",
    "description": "<p>Creates a new album according users permissions. Administrator, Photographer can create album</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "name",
            "description": "<p>Album name like { &quot;name&quot;: &quot;Animals&quot;}</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 201 Created": [
          {
            "group": "Success 201 Created",
            "type": "Json",
            "optional": false,
            "field": "Album",
            "description": "<p>the Album like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 Created\nLocation:  http://127.0.0.1/interPhoto/web/albums/66\n   {\n     \"name\": \"Animals\",\n     \"user_id\": 39,\n     \"id\": 66\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Albums"
  },
  {
    "type": "delete",
    "url": "/albums/id",
    "title": "Delete specific album",
    "name": "Delete_Album",
    "group": "Albums",
    "description": "<p>Deletes the unique id album according users permissions. Only Administrator can delete any album. Photographer and client are not allowed to action.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>Album ID</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 204 No content": [
          {
            "group": "Success 204 No content",
            "optional": false,
            "field": "Empty",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No content",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Albums"
  },
  {
    "type": "get",
    "url": "/albums",
    "title": "Index albums",
    "name": "Index_Albums",
    "group": "Albums",
    "description": "<p>Returns the users' albums according users permissions. Administrator can get all albums. Photographer and client only their own (allowed) albums. If photographer or client doesn't have any own or allowed albums index will be empty.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "No",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>name of the album for filtering like ?name=Wedding</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "List",
            "description": "<p>List of the Albums like [{key:value,}, {key:value,}]</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n[\n   {\n     \"id\":43,\n     \"user_id\":37,\n     \"name\":\"album2\",\n      \"active\":1,\n      \"created_at\":\"2016-04-18 17:42:56\",\n      \"modified_at\":\"2016-04-19 02:00:25\"\n    },\n     {\n      .......\n     }\n   ]",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Albums"
  },
  {
    "type": "put",
    "url": "/albums/id",
    "title": "Update specific album",
    "name": "Update_Album",
    "group": "Albums",
    "description": "<p>Updates the unique id album according users permissions. Administrator can update any album. Photographer and client only their own (allowed) albums.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>Album ID</p>"
          },
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "name",
            "description": "<p>Album name like { &quot;name&quot;: &quot;Peoples&quot;}</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "Album",
            "description": "<p>the Album like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n   {\n     \"id\":43,\n     \"user_id\":37,\n     \"name\":\"Peoples\",\n      \"active\":1,\n      \"created_at\":\"2016-04-18 17:42:56\",\n      \"modified_at\":\"2016-04-19 02:30:25\"\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Albums"
  },
  {
    "type": "get",
    "url": "/albums/id",
    "title": "View specific album",
    "name": "View_Album",
    "group": "Albums",
    "description": "<p>Returns the unique id album according users permissions. Administrator can view any album. Photographer and client only their own (allowed) albums.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>Album ID</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "Album",
            "description": "<p>the Album like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n   {\n     \"id\":43,\n     \"user_id\":37,\n     \"name\":\"album2\",\n     \"active\":1,\n     \"created_at\":\"2016-04-18 17:42:56\",\n     \"modified_at\":\"2016-04-19 02:00:25\"\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Albums"
  },
  {
    "type": "post",
    "url": "/auths/reset",
    "title": "Reset-code set and email",
    "name": "AskReset",
    "group": "Auths",
    "description": "<p>For specific user as Email generates reset code and send it via email</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>as body param</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "sent-email",
            "description": "<p>reset code</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "  HTTP/1.1 200 OK\n\nConnection →Keep-Alive\nContent-Length →0\nContent-Type →application/json; charset=UTF-8\nDate →Mon, 02 May 2016 11:31:04 GMT\nKeep-Alive →timeout=5, max=100\nServer →Apache/2.4.7 (Ubuntu)\nX-Powered-By →PHP/5.5.9-1ubuntu4.16",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "404",
            "description": "<p>Not found <code>404</code> User was not found, check the email</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "400",
            "description": "<p>Bad request <code>400</code> Email is  empty&quot;</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "404 Not found\n{\n \"name\": \"User was not found, check the email\",\n \"message\": \"No such token\",\n \"code\": 404,\n \"status\": 404,\n \"type\": \"yii\\\\web\\\\NotFoundHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n \"name\": \"Bad Request\",\n \"message\": \"Email is  empty\",\n \"code\": 400,\n \"status\": 400,\n \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n \"name\": \"Bad Request\",\n \"message\": \"Email with your reset code have been sent\",\n \"code\": 400,\n \"status\": 400,\n \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AuthsController.php",
    "groupTitle": "Auths"
  },
  {
    "type": "put",
    "url": "/auths/reset",
    "title": "The password reset",
    "name": "DoReset",
    "group": "Auths",
    "description": "<p>Resets the password of user with specific email and reset code</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>as body param</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Reset-code",
            "description": "<p>as body param</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "New-password",
            "description": "<p>as body param</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "changed-password",
            "description": "<p>for specific user</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "  HTTP/1.1 201 Created\n\nConnection →Keep-Alive\nContent-Length →0\nContent-Type →application/json; charset=UTF-8\nDate →Mon, 02 May 2016 11:42:38 GMT\nKeep-Alive →timeout=5, max=100\nServer →Apache/2.4.7 (Ubuntu)\nX-Powered-By →PHP/5.5.9-1ubuntu4.16",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "404",
            "description": "<p>Not found <code>404</code> User was not found, check the email</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "400",
            "description": "<p>Bad request <code>400</code> Reset code has been used</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "404 Not found\n{\n \"name\":  \"Not Found\",\n \"message\":  \"User was not found, check the email\",\n \"code\": 404,\n \"status\": 404,\n \"type\": \"yii\\\\web\\\\NotFoundHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "404 Not found\n{\n \"name\":  \"Not Found\",\n \"message\":  \"User was not found, check the reset code\",\n \"code\": 404,\n \"status\": 404,\n \"type\": \"yii\\\\web\\\\NotFoundHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n  \"name\": \"Bad Request\",\n  \"message\": \"Reset code has been used\",\n  \"code\": 400,\n  \"status\": 400,\n  \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n name\": \"Bad Request\",\n \"message\": \"Email or(and) reset code or(and) password is (are) empty\",\n \"code\": 400,\n \"status\": 400,\n \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n name\": \"Bad Request\",\n \"message\": \"Email and reset code are dismatch each other\",\n \"code\": 400,\n \"status\": 400,\n \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n name\": \"Bad Request\",\n \"message\": \"Reset code is expired\",\n \"code\": 400,\n \"status\": 400,\n \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AuthsController.php",
    "groupTitle": "Auths"
  },
  {
    "type": "post",
    "url": "/auths/login",
    "title": "Login",
    "name": "Login",
    "group": "Auths",
    "description": "<p>Returns the access token for api</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Password",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "Access-token",
            "description": "<p>Access Token as header Autorization</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n\nAutorization →Bearer HP8h43Eb9LHJPUZAi3LKNcohZV9bQnN4\nConnection →Keep-Alive\nContent-Length →4\nContent-Type →application/json; charset=UTF-8\nDate →Mon, 02 May 2016 10:57:24 GMT\nKeep-Alive →timeout=5, max=100\nServer →Apache/2.4.7 (Ubuntu)\nX-Powered-By →PHP/5.5.9-1ubuntu4.16",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Not",
            "description": "<p>found <code>404</code> User was not found, check the email or password</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Bad",
            "description": "<p>request <code>400</code> Email or(and) password is (are) empty</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "404 Not found\n{\n \"name\": \"Not Found\",\n \"message\": \"User was not found, check the email or password\",\n \"code\": 404,\n \"status\": 404,\n \"type\": \"yii\\\\web\\\\NotFoundHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n \"name\": \"Bad Request\",\n \"message\": \"Email or(and) password is (are) empty\",\n \"code\": 400,\n \"status\": 400,\n \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AuthsController.php",
    "groupTitle": "Auths"
  },
  {
    "type": "delete",
    "url": "/auths/logout",
    "title": "Logout",
    "name": "Logout",
    "group": "Auths",
    "description": "<p>Resets to empty the access token for api</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Access-token",
            "description": "<p>as header Autorizarion</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "Www-Authenticate",
            "description": "<p>Header Www-Authenticate →Basic realm=&quot;api&quot;</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "  HTTP/1.1 200 OK\n\nConnection →Keep-Alive\nContent-Length →0\nContent-Type →application/json; charset=UTF-8\nDate →Mon, 02 May 2016 11:16:43 GMT\nKeep-Alive →timeout=5, max=100\nServer →Apache/2.4.7 (Ubuntu)\nWww-Authenticate →Basic realm=\"api\"\nX-Powered-By →PHP/5.5.9-1ubuntu4.16",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "404",
            "description": "<p>Not found <code>404</code> No such token</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "400",
            "description": "<p>Bad request <code>400</code> Incorrect token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "404 Not found\n{\n \"name\": \"Not Found\",\n \"message\": \"No such token\",\n \"code\": 404,\n \"status\": 404,\n \"type\": \"yii\\\\web\\\\NotFoundHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "400 Bad request\n{\n \"name\": \"Bad Request\",\n \"message\": \"Incorrect token\",\n \"code\": 400,\n \"status\": 400,\n \"type\": \"yii\\\\web\\\\BadRequestHttpException\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AuthsController.php",
    "groupTitle": "Auths"
  },
  {
    "type": "head",
    "url": "/auths/reset",
    "title": "State of reset code",
    "name": "StateReset",
    "group": "Auths",
    "description": "<p>Returns the state of reset code as headers Reset-Code-Used and Reset-Code-Valid-At</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Reset-code",
            "description": "<p>as header reset-code</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Reset-Code-Used",
            "description": "<p>0 - has not been used yet, 1 - has been used</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Reset-Code-Valid-At",
            "description": "<p>Date and time is valid for specific reset code</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "  HTTP/1.1 200 OK\n\nConnection →Keep-Alive\nContent-Type →application/json; charset=UTF-8\nDate →Mon, 02 May 2016 12:25:45 GMT\nKeep-Alive →timeout=5, max=100\nReset-Code-Used →0\nReset-Code-Valid-At →2016-05-01 22:11:26\nServer →Apache/2.4.7 (Ubuntu)\nX-Powered-By →PHP/5.5.9-1ubuntu4.16",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "404",
            "description": "<p>Not found <code>404</code></p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "400",
            "description": "<p>Bad request <code>400</code> Reset code has been used</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./controllers/AuthsController.php",
    "groupTitle": "Auths"
  },
  {
    "type": "post",
    "url": "/albums/id/images",
    "title": "Create  image in the specific album",
    "name": "Create_Image",
    "group": "Images",
    "description": "<p>Creates image in the specific album  according users permissions. Administrator can create any image of any album. Photographer can create  image in their own albums. Client doesn't have permission to creat image.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "UploadForm[imageFile]",
            "description": "<p>File of image to upload jpg, png. Key of uploding must be UploadForm[imageFile].</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>multipart/form-data</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Internal",
            "description": "<p>Server Error <code>500 Probably album id is not correct or doesn't exist</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "\"name\": \"Internal Server Error\",\n\"message\": \"Failed to action for unknown reason. Check the id album\",\n\"code\": 0,\n\"status\": 500,\n\"type\": \"yii\\\\web\\\\ServerErrorHttpException\"",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Images"
  },
  {
    "type": "delete",
    "url": "/albums/id/images/id",
    "title": "Delete specific image in the specific album",
    "name": "Delete_Image",
    "group": "Images",
    "description": "<p>Delets the unique id image in the specific album  according users permissions. Administrator can delete any image of any album. Photographer can delete image only of  their own (allowed) albums.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "ID_Album",
            "description": "<p>ID album</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "ID_Image",
            "description": "<p>ID image</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 204 No content": [
          {
            "group": "Success 204 No content",
            "optional": false,
            "field": "Empty",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No content",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Images"
  },
  {
    "type": "get",
    "url": "/albums/id/images",
    "title": "Index  image of the specific album",
    "name": "Index_Image",
    "group": "Images",
    "description": "<p>Returns the list if images of the specific album  according users permissions. Administrator can index any image of any album. Photographer and client can index image only of  their own (allowed) albums.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "ID",
            "description": "<p>Album ID album</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Status",
            "description": "<p>You can check of the resizing image state. Just type ?status-=complete ot status=new. The status=complete means that images was resized</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "List",
            "description": "<p>of images the Image like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK\n      [\n{\n  \"id\": 11,\n  \"album_id\": 16,\n  \"image\": \"users_cache.png\",\n  \"created_at\": 1462993051\n},\n{\n  \"id\": 15,\n  \"album_id\": 16,\n  \"image\": \"users_cache.png\",\n  \"created_at\": 1462994046\n},",
          "type": "json"
        },
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK     ]\n[\n{\n  \"image\": \"users_cache.png\",\n  \"id\": \"11\",\n  \"status\": \"complete\"\n},\n{\n  \"image\": \"users_cache.png\",\n  \"id\": \"15\",\n  \"status\": \"complete\"\n},\n{\n  \"image\": \"users_cache.png\",\n  \"id\": \"16\",\n  \"status\": \"complete\"\n}\n]",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Images"
  },
  {
    "type": "put",
    "url": "/albums/id/images/id",
    "title": "Update image",
    "description": "<p>Action is not allowed. To update photo you should delete the photo  and create new one.</p>",
    "name": "Update_Image",
    "group": "Images",
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Not_allowed",
            "description": "<p><code>405</code> Method is not allowed</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Images"
  },
  {
    "type": "get",
    "url": "/albums/id/images/id",
    "title": "View specific image of the specific album",
    "name": "View_Image",
    "group": "Images",
    "description": "<p>Returns the unique id image of the specific album  according users permissions. Administrator can view any image of any album. Photographer and client can view image only of their own (allowed) albums. Photographer gives access  to his own albums  to the client.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "ID_Album",
            "description": "<p>Album ID album</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "ID_Image",
            "description": "<p>ID image</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token like Bearer .....</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "Image",
            "description": "<p>the Image like {key:value,}</p>"
          },
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "ResizedImages",
            "description": "<p>the Resized Images like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"Image\": {\n    \"id\": 11,\n    \"album_id\": 16,\n    \"image\": \"users_cache.png\",\n    \"created_at\": 1462993051\n},\n   \"Resized Images\": [\n[\n{\n  \"status\": \"complete\",\n  \"image_id\": 11,\n  \"id\": 21,\n  \"size\": \"100\",\n  \"origin\": \"users_cache.png\",\n  \"comment\": null\n},\n{\n  \"status\": \"complete\",\n  \"image_id\": 11,\n  \"id\": 22,\n  \"size\": \"400\",\n  \"origin\": \"users_cache.png\",\n  \"comment\": null\n} \n ]]\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/AlbumsController.php",
    "groupTitle": "Images"
  },
  {
    "type": "post",
    "url": "/albums",
    "title": "Create new user",
    "name": "Create_User",
    "group": "Users",
    "description": "<p>Creates a new user according users permissions. Only Administrator can create user</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>User ID</p>"
          },
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "name",
            "description": "<p>User name like { &quot;name&quot;: &quot;Anna&quot;}</p>"
          },
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "email",
            "description": "<p>User email like { &quot;email&quot;: &quot;Anna@a.com&quot;}</p>"
          },
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "password",
            "description": "<p>User like { &quot;password&quot;: &quot;Anna&quot;}</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 201 Created": [
          {
            "group": "Success 201 Created",
            "type": "Json",
            "optional": false,
            "field": "User",
            "description": "<p>the User like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "  HTTP/1.1 201 Created\n{\n \"name\": \"mmmm\",\n \"email\": \"s@s.v\",\n \"role\": \"admin\",\n \"id\": 103\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "delete",
    "url": "/users/id",
    "title": "Delete specific user",
    "name": "Delete_User",
    "group": "Users",
    "description": "<p>Deletes the unique id user according users permissions. Only Administrator can delete any user. Photographer and client are not allowed to action.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>User ID</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 204 No content": [
          {
            "group": "Success 204 No content",
            "optional": false,
            "field": "Empty",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No content",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "get",
    "url": "/users",
    "title": "Index users",
    "name": "Index_Users",
    "group": "Users",
    "description": "<p>Returns the list of the users according users permissions. Administrator can get all users. Photographer and client can index only own information.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "No",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "List",
            "description": "<p>List of the Users like [{key:value,}, {key:value,}]</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK\n    [\n{\n  \"id\": 37,\n  \"role\": \"admin\",\n  \"name\": \"mmm\",\n  \"email\": \"travers.nk@gmail.com\",\n  \"phone\": \"10000\",\n  \"modified_at\": \"2016-05-10 15:40:54\",\n  \"created_at\": \"2016-04-18 16:12:09\"\n},\n{\n  \"id\": 39,\n  \"role\": \"photographer\",\n  \"name\": \"photo\",\n  \"email\": \"photo@gmail.com\",\n  \"phone\": \"000-000-00-00\",\n  \"modified_at\": \"2016-05-10 15:40:49\",\n  \"created_at\": \"2016-04-18 16:14:17\"\n},",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "put",
    "url": "/users/id",
    "title": "Update specific user",
    "name": "Update_User",
    "group": "Users",
    "description": "<p>Updates the unique id user according users permissions. Administrator can update any user. Photographer and client only their own user information.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>User ID</p>"
          },
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "name",
            "description": "<p>User name like { &quot;name&quot;: &quot;Anna&quot;} add other fields, excluding email and role, email and  is nor allowed to change</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "User",
            "description": "<p>the User like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK\n       {\n    {\n\"id\": 37,\n\"role\": \"admin\",\n\"name\": \"mmmm\",\n\"email\": \"travers.nk@gmail.com\",\n\"phone\": \"10000\",\n\"modified_at\": \"2016-05-10 15:40:54\",\n\"created_at\": \"2016-04-18 16:12:09\"\n   }\n        }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "type": "get",
    "url": "/users/id",
    "title": "View specific user",
    "name": "View_User",
    "group": "Users",
    "description": "<p>Returns the unique ID user according users permissions. Administrator can view any user. Photographer and client only their own user information.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>User ID</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "User",
            "description": "<p>the User like {key:value,}</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK\n     {\n \"id\": 37,\n\"role\": \"admin\",\n\"name\": \"mmm\",\n\"email\": \"travers.nk@gmail.com\",\n\"phone\": \"10000\",\n\"modified_at\": \"2016-05-10 15:40:54\",\n\"created_at\": \"2016-04-18 16:12:09\"\n      }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p><code>401</code> User needs to be autorized to action</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Forbidden",
            "description": "<p><code>403</code> User's not allowed to action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "401 Unauthorized\n{\n   \"name\":\"Unauthorized\",\n   \"message\":\"You are requesting with an invalid credential.\",\n   \"code\":0,\"status\":401,\"type\":\"yii\\\\web\\\\UnauthorizedHttpException\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "403 Forbidden\n{\n   \"name\": \"Forbidden\",\n   \"message\": \"You are not allowed to perform this action.\",\n   \"code\": 0,\n   \"status\": 403,\n   \"type\": \"yii\\\\web\\\\ForbiddenHttpException\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./controllers/UsersController.php",
    "groupTitle": "Users"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./doc/main.js",
    "group": "_var_www_interPhoto_doc_main_js",
    "groupTitle": "_var_www_interPhoto_doc_main_js",
    "name": ""
  }
] });
