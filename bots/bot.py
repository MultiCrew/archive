import discord,pymysql,asyncio

client = discord.Client()


# fucntion to check if a user is banned
#
async def is_banned(username):

    # create connection
    conn = pymysql.connect(host='localhost', user='root', password='z!fA8Q>`gYC&_;d9T"jD`.nZc(ncaY*N', db='sso')
    mysql = conn.cursor()

    qry = "SELECT username FROM bans WHERE username=%s"
    data = str(username)
    mysql.execute(qry, data)
    result = mysql.fetchone()
    if result is None:
        banned = False
    else:
        banned = True
    return banned


# function to get user data from Portal
#
async def get_user_data(id):

    # create connection
    conn = pymysql.connect(host='localhost', user='root', password='z!fA8Q>`gYC&_;d9T"jD`.nZc(ncaY*N', db='sso')
    mysql = conn.cursor()

    qry = "SELECT username,discord FROM users WHERE id=%s"
    data = int(id)
    mysql.execute(qry, data)
    result = mysql.fetchone()
    username = result[0]
    discord_id = result[1]

    return username,discord_id


# function to check validity of discord id
#
async def check_discord(discord_id):

    if discord_id == "" or discord_id is None:
        invalidDiscord = True
    else:
        invalidDiscord = False
    return invalidDiscord


# function to initially link accounts when discord ID added to profile
# CALLED FROM PORTAL ACCOUNT AND USER_EDIT PAGES
async def link_accounts(id):

    # get Portal data
    username,discord_id = await get_user_data(id)
    banned = await is_banned(username)
    invalidDiscord = await check_discord(discord_id)

    print(banned)
    print(invalidDiscord)

    # try to assign trainee role and change nickname if their discord ID appears valid and they're not banned
    if not (invalidDiscord or banned):

        try:
            user = client.get_server("440545668168286249").get_member(discord_id)   # find the member with the ID

            # give them trainee
            newrole = discord.utils.get(client.get_server("440545668168286249").roles, name='trainee')
            await client.replace_roles(user, newrole)

            # set their server nickname to their Portal username
            await client.change_nickname(user, username)

            status = True

        except TypeError:
            status = 'failed'

    else:
        status = 'invalid'

    return status


# function to change a user's username
# CALLED FROM PORTAL ACCOUNT AND USER_EDIT PAGES
async def change_username(id):

    # create connection
    conn = pymysql.connect(host='localhost', user='root', password='z!fA8Q>`gYC&_;d9T"jD`.nZc(ncaY*N', db='sso')
    mysql = conn.cursor()

    # get Portal data
    username,discord_id = await get_user_data(id)
    banned = await is_banned(username)
    invalidDiscord = await check_discord(discord_id)

    # try to change nickname if their discord ID appears valid and they're not banned
    if not (invalidDiscord or banned):

        try:
            user = client.get_server("440545668168286249").get_member(discord_id)   # find the member with the ID

            # set their server nickname to their Portal username
            await client.change_nickname(user, username)

            status = True

        except TypeError:
            status = False

    else:
        status = False

    return status


# function to *change* the user's role
# CALLED FROM PORTAL USER_EDIT WHEN SPECIFIC ROLES ARE SELECTED
async def role_change(id, newrole):

    # create connection
    conn = pymysql.connect(host='localhost', user='root', password='z!fA8Q>`gYC&_;d9T"jD`.nZc(ncaY*N', db='sso')
    mysql = conn.cursor()

    # get Portal data
    username,discord_id = await get_user_data(id)
    banned = await is_banned(username)
    invalidDiscord = await check_discord(discord_id)

    # try to assign new role if their discord ID appears valid and they're not banned
    if not (invalidDiscord or banned):

        try:
            user = client.get_server("440545668168286249").get_member(discord_id)   # find the member with the ID

            # give them new role
            newrole = discord.utils.get(client.get_server("440545668168286249").roles, name=newrole)
            await client.replace_roles(user, newrole)

            status = True

        except TypeError:
            status = 'failed'

    else:
        status = 'invalid'

    return status


# function to *add* a role to a user
# CALLED FROM PORTAL USER_EDIT WHEN SPECIFIC ROLES ARE SELECTED
async def role_add(id, newrole):

    # create connection
    conn = pymysql.connect(host='localhost', user='root', password='z!fA8Q>`gYC&_;d9T"jD`.nZc(ncaY*N', db='sso')
    mysql = conn.cursor()

    # get Portal data
    username,discord_id = await get_user_data(id)
    banned = await is_banned(username)
    invalidDiscord = await check_discord(discord_id)

    # try to assign new role if their discord ID appears valid and they're not banned
    if not invalidDiscord and not banned:

        try:
            user = client.get_server("440545668168286249").get_member(discord_id)   # find the member with the ID

            # give them new role
            newrole = discord.utils.get(client.get_server("440545668168286249").roles, name=newrole)
            await client.add_roles(user, newrole)

            status = True

        except TypeError:
            status = False

    else:
        status = False

    return status


# function to replace a user's roles with the banned role
# CALLED FROM PORTAL BAN WHEN A BAN IS APPLIED TO A USER
async def ban_user(discord_id):

    user = client.get_server("440545668168286249").get_member(discord_id)
    banrole = discord.utils.get(client.get_server("440545668168286249").roles, name='banned')
    await client.replace_roles(user, banrole)


# function to replace the user's banned role with the appropriate roles
# CALLED FROM PORTAL BAN WHEN A BAN IS LIFTED MANUALLY
async def unban_user(discord_id, roles):

    user = client.get_server("440545668168286249").get_member(discord_id)

    # if the first role to be assigned is trainee then assign it and check for more
    if roles[0]=='trainee':

        # assign trainee role
        trainee = discord.utils.get(client.get_server("440545668168286249").roles, name='trainee')
        await client.replace_roles(user, trainee)

        # if there are more roles to be assigned then assign them
        if len(roles)>1:
            for x in range(1, len(roles)):
                role = discord.utils.get(client.get_server("440545668168286249").roles, name=roles[x])
                await client.replace_roles(user, role)

    # otherwise just get on with it
    else:
        role = discord.utils.get(client.get_server("440545668168286249").roles, name=roles[0])
        await client.replace_roles(user, role)


# function to handle the web socket
#
async def socket_server(reader, writer):

    socket = await reader.read(100)
    message = socket.decode()
    data = message.split(',')
    type = data[0]

    if type == 'link_accounts':
        user_id = data[1]
        status = str(await link_accounts(user_id)) + ' link'
        print(status)
    elif type == 'role_add':
        user_id = data[1]
        role = data[2]
        status = str(await role_add(user_id, role)) + ' add'
        print(status)
    elif type == 'role_change':
        user_id = data[1]
        role = data[2]
        print(user_id)
        print(role)
        status = str(await role_change(user_id, role)) + ' change'
        print(status)
    # elif data[0] == 'ban':
    #     await ban_user(data[1])
    # elif data[0] == 'unban':
    #     roles = [data[1]]
    #     await unban_user(roles)

    writer.close()


# MESSAGE COMMAND HANDLING
# EVENT: message sent
@client.event
async def on_message(message):

    # to send msg to rules channel
    if message.content.startswith('!rules'):
        if "440550777912819712" in [role.id for role in message.author.roles]:
            rule = message.content.replace('!rules', '')
            rules = discord.utils.get(message.server.channels, name="rules", type=discord.ChannelType.text)
            await client.send_message(rules, rule)
        else:
            await client.delete_message(message)

    # to edit msg in rules channel
    elif message.content.startswith('!editrules'):
        if "440550777912819712" in [role.id for role in message.author.roles]:
            tempmessage = message.content.split(' ')
            channel = discord.utils.get(client.get_all_channels(), server__name='MultiCrew', name='rules')
            oldmessage = await client.get_message(channel, tempmessage[1])
            tempmessage.pop(0)
            tempmessage.pop(0)
            newmessage = ' '.join(tempmessage)
            await client.edit_message(oldmessage, new_content=newmessage)
        else:
            await client.delete_message(message)

    # to send msg to announcement channel
    elif message.content.startswith('!announce'):
        if "440550777912819712" in [role.id for role in message.author.roles]:
            announce = message.content.replace('!announce', '')
            announcechan = discord.utils.get(message.server.channels, name="announcements", type=discord.ChannelType.text)
            await client.send_message(announcechan, announce)
        else:
            await client.delete_message(message)

    # to edit msg in announcement channel
    elif message.content.startswith('!editannounce'):
        if "440550777912819712" in [role.id for role in message.author.roles]:
            tempmessage = message.content.split(' ')
            channel = discord.utils.get(client.get_all_channels(), server__name='MultiCrew', name='announcements')
            oldmessage = await client.get_message(channel, tempmessage[1])
            tempmessage.pop(0)
            tempmessage.pop(0)
            newmessage = ' '.join(tempmessage)
            await client.edit_message(oldmessage, new_content=newmessage)
        else:
            await client.delete_message(message)


# direct message the user with their discord ID
# EVENT: first time a user joins the server
@client.event
async def on_member_join(member):

    discord_id = member.id
    conn = pymysql.connect(host='localhost', user='root', password='z!fA8Q>`gYC&_;d9T"jD`.nZc(ncaY*N', db='sso')
    mysql = conn.cursor()

    qry = "SELECT type FROM users WHERE discord =%s"
    data = int(discord_id)
    mysql.execute(qry, data)
    result = mysql.fetchone()

    if len(result) > 0:
        try:
            usertype = result[0]
            userstatus = "return"
            await link_accounts(id)
            msg = "{0.mention}, Welcome back to the MultiCrew Discord Server. Since you already have your Discord ID in your MultiCrew Portal account, your role has been assigned!"
            await client.send_message(member, msg.format(member))
        except TypeError:
            msg = "{0.mention}, Welcome to the MultiCrew Discord Server. Make sure you have an account at https://multicrew.co.uk to be able to get your role assigned, once your account is made type enter your Discord ID: {0.id} into your MultiCrew Portal Profile. If you need any help don't hesitate to contact an Admin.\nEnjoy the server!"
            await client.send_message(member, msg.format(member))
    else:
        msg = "{0.mention}, Welcome to the MultiCrew Discord Server. Make sure you have an account at https://multicrew.co.uk to be able to get your role assigned, once your account is made type enter your Discord ID: {0.id} into your MultiCrew Portal Profile. If you need any help don't hesitate to contact an Admin.\nEnjoy the server!"
        await client.send_message(member, msg.format(member))


# start the bot
#
@client.event
async def on_ready():
    await client.change_presence(game=discord.Game(name='multicrew.co.uk'))
    print('Logged in as')
    print(client.user.name)
    print(client.user.id)
    print('------')

    asyncio.run_coroutine_threadsafe(asyncio.start_server(socket_server, '127.0.0.1', 9001), client.loop)


client.run('NDQ1NjkxNjgyMDM4NzQzMDUw.DduLGA.3dwE7ZL43jA5Ai4ZiK-QtE1cD4I')
