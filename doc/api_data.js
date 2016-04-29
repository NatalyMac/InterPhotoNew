define({ "api": [
  {
    "type": "post",
    "url": "/albums",
    "title": "Create new album",
    "name": "Create_Albums",
    "group": "Album",
    "description": "<p>Creates a new album according users permissions. Administrator, Photographer and Client  can create album</p>",
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
            "description": "<p>Album name like { &quot;name&quot;: &quot;Animals&quot;}</p>"
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
    "groupTitle": "Album"
  },
  {
    "type": "delete",
    "url": "/albums/id",
    "title": "Delete specific album",
    "name": "Delete_Albums",
    "group": "Album",
    "description": "<p>Deletes the inique id album according users permissions. Only Administrator can delete any album. Photographer and client are not allowed to action.</p>",
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
    "groupTitle": "Album"
  },
  {
    "type": "get",
    "url": "/albums",
    "title": "Index albums",
    "name": "Index_Albums",
    "group": "Album",
    "description": "<p>Returns the users' albums according users permissions. Administrator can get all albums. Photographer and client only their own (allowed) albums.</p>",
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
    "groupTitle": "Album"
  },
  {
    "type": "put",
    "url": "/albums/id",
    "title": "Update specific album",
    "name": "Update_Albums",
    "group": "Album",
    "description": "<p>Updates the inique id album according users permissions. Administrator can update any album. Photographer and client only their own (allowed) albums.</p>",
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
    "groupTitle": "Album"
  },
  {
    "type": "get",
    "url": "/albums/id",
    "title": "View specific album",
    "name": "View_Albums",
    "group": "Album",
    "description": "<p>Returns the inique id album according users permissions. Administrator can view any album. Photographer and client only their own (allowed) albums.</p>",
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
    "groupTitle": "Album"
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
