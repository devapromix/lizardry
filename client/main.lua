username = ""
userpass = ""
world = "elvion"
action = "login"
version = "0.2.2"

function love.load()
	local http = require("socket.http")
	r, e = http.request("http://lizardry.pp.ua/"..world.."/index.php?username="..username.."&userpass="..userpass.."&action="..action)
	
	math.randomseed(os.time())
	love.graphics.setDefaultFilter("nearest", "nearest")
	love.window.setVSync(1)
	love.window.setTitle("Lizardry ["..world.."]")
	
	lizardry_logo = love.graphics.newImage("resources/images/lizardry/lizardry_logo.png")
end

function love.draw()
	--love.graphics.print(r)
	love.graphics.draw(lizardry_logo, 280, 100)
	love.graphics.print("v."..version, 700, 250)
end

function love.update(dt)

end

function love.keypressed(key, unicode)

end