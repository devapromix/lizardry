local states = {}

local stateFiles = {}

local currentState = "default"

local love2dCallbacksList =
	{
		"keypressed",
		"keyreleased",
		"filedropped",
		"directorydropped",
		"draw",
		"update",
		"wheelmoved",
		"mousepressed",
		"mousemoved",
		"mousereleased",
		"textinput",
		"focus",
		"lowmemory",
		"mousefocus",
		"resize",
		"quit",
		"threaderror",
		"enter",
		"visible"
	}

local function defaultInitialize(stateFile)
	for _,callback in pairs(love2dCallbacksList) do
		stateFile[callback] = stateFile[callback] or function() end
		stateFile.open = stateFile.open or function() end
	end
end

local function add(stateName)
	stateFiles[stateName] = require("states/"..stateName)
	defaultInitialize(stateFiles[stateName])
end

function states.setup()
	for _,callback in pairs(love2dCallbacksList) do
		states[callback] = 		
		function(...)
			stateFiles[currentState][callback](unpack({...}))
		end
		love[callback] = love[callback] or states[callback]
	end
end

function states.switch(newState,params)
	if not stateFiles[newState] then
		add(newState)
	end

	currentState = newState
	local params = type(params)=="table" and params or {}
	stateFiles[newState].open(params)
end

return states