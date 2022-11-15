utf8 = require("utf8")


username = "serg"
userpass = ""
world = "elvion"
action = "login"
version = "0.2.2"

assets = require('libraries.cargo').init('resources')

resources = {
    fonts = {},
}

function love.load()
	local http = require("socket.http")
	r, e = http.request("http://lizardry.pp.ua/"..world.."/index.php?username="..username.."&userpass="..userpass.."&action="..action)
	
	math.randomseed(os.time())
	love.graphics.setDefaultFilter("nearest", "nearest")
	love.window.setVSync(1)
	love.window.setTitle("Lizardry ["..world.."]")
	
	lizardry_logo = love.graphics.newImage("resources/images/lizardry/lizardry_logo.png")
	background_menu_main = love.graphics.newImage("resources/images/backgrounds/castle.png")
	
	resources.fonts.main_font 	= assets.fonts.main_font(16)
end

function love.draw()
	love.graphics.setFont(resources.fonts.main_font)
	love.graphics.print(r)
	love.graphics.draw(background_menu_main, 0, 0)
	love.graphics.draw(lizardry_logo, 280, 120)
	love.graphics.print("v."..version, 670, 260)
end

function love.update(dt)

end

function love.keypressed(key, unicode)

end