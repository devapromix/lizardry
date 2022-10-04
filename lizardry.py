import requests
import json

VERSION = "0.2.0"
SERVER = 'lizardry'

class Login:
    def __init__(self, username, userpass):
        self.username = username
        self.userpass = userpass

def enter():
    username = input("Логин:")
    userpass = input("Пароль:")
    login = Login(username, userpass)
    response = requests.get('http://lizardry.pp.ua/' + SERVER + '/index.php?username=' + login.username + '&userpass=' + login.userpass + '&action=login')
    flag = response.text == '{"login":"ok"}'
    if flag:
        print("Добро пожаловать в Лизардри в." + VERSION)
    return login, flag

def town(login):
    response = requests.get('http://lizardry.pp.ua/' + SERVER + '/index.php?username=' + login.username + '&userpass=' + login.userpass + '&action=town')
    jsons = json.loads(response.text)
    #print(response.text)
    #print(jsons['user_name'])
    #print(len(jsons))

    #print(len(jsons['links']))
    #print(jsons['char_bank'])
    #print(jsons['char_gold'])

    print(jsons['char_region_town_name'])
    print(jsons['description'])
    n = 1
    for j in jsons['links']:
        print(str(n) + '. ' + j['title'])#+'->'+j['link'])
        n = n + 1
    choice = input("> ")

if __name__ == "__main__":
    login, flag = enter()
    if flag:
        town(login)