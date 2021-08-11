if ngx.req.get_method() ~= "POST" then
    ngx.log(ngx.ERR, "wrong event request method: ", ngx.req.get_method())
    return ngx.exit (ngx.HTTP_NOT_ALLOWED)
end

ngx.req.read_body()
local data = ngx.req.get_body_data()
if not data then
    ngx.log(ngx.ERR, "failed to get request body")
    return ngx.exit (ngx.HTTP_BAD_REQUEST)
end

local args, err = ngx.req.get_post_args()
for key, val in pairs(args) do
    if key == "checker" then
        if val == "fpm" then
          ngx.redirect("/testpost")
          return
        end
    end
    if key == "str" then
     str = val
    end
end
if str == nil then
    ngx.log(ngx.ERR, "'str' parameter in POST request was not set. str=", str)
    return ngx.exit (ngx.HTTP_BAD_REQUEST)
end
-- len = string.len(str)
len = #str -- тоже самое
i = 0
open = 0
while true do
    if i >= len then
        break
    end
    i = i + 1
    item = string.sub(str, i, i)
    if item == "(" then
        open = open + 1
    elseif item == ")" then
        open = open - 1
    end
    if open < 0 then
        break
    end
end
if open == 0 and len > 0 then
    ngx.status = ngx.HTTP_OK
    ngx.say("Success: OK")
else
    -- Статус 400 в случае ошибки
    ngx.status = ngx.HTTP_BAD_REQUEST
    ngx.say("Error 400: Bad request")
end
