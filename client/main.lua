utf8 = require("utf8")

username = "serg"
userpass = ""
world = "elvion"

server = "http://lizardry.pp.ua/"
version = "0.2.3"
scene = "login"
usersession = ""
response = ""

http = require("socket.http")
md5 = require('libraries.md5')
json = require "libraries.json"
assets = require('libraries.cargo').init('resources')

resources = {
    fonts = {},
}

function string.explode(str, div)
    assert(type(str) == "string" and type(div) == "string", "invalid arguments")
    local o = {}
    while true do
        local pos1,pos2 = str:find(div)
        if not pos1 then
            o[#o+1] = str
            break
        end
        o[#o+1],str = str:sub(1,pos1-1),str:sub(pos2+1)
    end
    return o
end

function login(action)
	response, error = http.request(server..world.."/index.php?username="..username.."&userpass="..md5.sumhexa(userpass).."&usersession="..usersession.."&action="..action)
	return json.decode(response)
end

function love.load()
	math.randomseed(os.time())
	love.graphics.setDefaultFilter("nearest", "nearest")
	love.window.setVSync(1)
	love.window.setTitle("Lizardry ["..world.."]")
	
	lizardry_logo = love.graphics.newImage("resources/images/lizardry/lizardry_logo.png")
	background_menu_main = love.graphics.newImage("resources/images/backgrounds/castle.png")
	
	resources.fonts.main_font = assets.fonts.main_font(16)
	
	user = login("login")
	if user['login'] == "ok" then
		usersession = user['session']
		user = login("town")
		scene = "town"
	end
	
end

function love.draw()
	love.graphics.setFont(resources.fonts.main_font)
	if scene == "login" then
		love.graphics.draw(background_menu_main, 0, 0)
		love.graphics.draw(lizardry_logo, 280, 120)
		love.graphics.print("v."..version, 670, 260)
	end

	if scene == "town" then
		love.graphics.print(user['title'], 300, 0)

		y = 0
		for i = 1, #user['links'] do
			love.graphics.print(user['links'][i]['title'], 0, y)
			y = y + 16
		end

		local str = user['description']
		tbl = string.explode(str, " ")
		y = 0
		p = 1
		s = ""
		for i = 1,#tbl do
			s = s..tbl[i].." "
			if (string.len(s) > 70) then
				love.graphics.print(s, 300, y + 20)
				y = y + 16
				s = ""
			end
		end

		love.graphics.print(user['char_name'], 800, 0)
		love.graphics.print(user['char_equip_weapon_name'], 800, 16)
		love.graphics.print(user['char_equip_armor_name'], 800, 32)

	end

end

function love.update(dt)

end

function love.keypressed(key, unicode)

end