import discord
import pymysql
import texttable as tt
import asyncio

tab = tt.Texttable()

client = discord.Client()


async def web_accept(reqid, discid):
    conn = pymysql.connect(host='localhost', user='discord', password='s+pq4fN@2J@VeGkY+V#ry-Hy', db='discord', autocommit=True)
    a = conn.cursor()
    sql = 'SELECT * FROM `requests` WHERE `id` = "' + reqid + '"'
    a.execute(sql)
    request = a.fetchone()
    print(request)
    print(request[1])
    requesteeid = request[1]
    requestee = await client.get_user_info(user_id=request[1])
    acceptee = await client.get_user_info(user_id=discid)
    # message both the user accepting the request and the user who made the request
    await accept_msg(requestee, acceptee, reqid)
    sql = "INSERT INTO accepted (id, requestee, acceptee, aircraft, dep, arr)" "VALUES (%s, %s, %s, %s, %s, %s)"
    data = (reqid, requesteeid, discid, request[2].upper(), request[3].upper(), request[4].upper())
    a.execute(sql, data)
    sql = "DELETE FROM requests WHERE id=%s"
    data = reqid
    a.execute(sql, data)


async def accept_msg(requestee, acceptee, requestid):
    msgpt1 = " just accepted "
    msgpt2 = "'s Shared Cockpit Request. The Request ID was "
    msgpt3 = "\n**Aircraft Type:** "
    msgpt4 = "\n**Departure:** "
    msgpt5 = "\n**Arrival:** "
    msgpt6 = "\nHead to https://copilot.multicrew.co.uk/dispatch/plan.php to plan your flight."
    conn = pymysql.connect(host='localhost', user='discord', password='s+pq4fN@2J@VeGkY+V#ry-Hy', db='discord', autocommit=True)
    a = conn.cursor()
    sql = "SELECT * FROM requests WHERE id=%s"
    data = requestid
    a.execute(sql, data)
    r = a.fetchone()
    message = "**" + acceptee.mention + msgpt1 + requestee.mention + msgpt2 + requestid + "**" + msgpt3 + r[2].upper() + msgpt4 + r[3].upper() + msgpt5 + r[4].upper() + msgpt6
    await client.send_message(destination=client.get_channel(id="486250233253199904"), content=message)
    everyone = discord.PermissionOverwrite(connect=False)
    users = discord.PermissionOverwrite(connect=True)
    server = client.get_server("440545668168286249")
    createdchannel = await client.create_channel(server, 'Shared Cockpit Room' + requestid, (server.default_role, everyone), (requestee, users), (acceptee, users), type=discord.ChannelType.voice)
    await client.edit_channel(createdchannel, user_limit=2, parent_id=442774823505231881)
    return True


async def socket_server(reader, writer):

    data = await reader.read(100)
    message = data.decode()
    print(message)
    dataarray = message.split(',')
    if dataarray[0] == "copilot":
        await web_accept(dataarray[1], dataarray[2])

    writer.close()


def hasNumbers(inputString):
    return any(char.isdigit() for char in inputString)


@client.event
async def on_message(message):

    conn = pymysql.connect(host='localhost', user='discord', password='s+pq4fN@2J@VeGkY+V#ry-Hy', db='discord', autocommit=True)

    # search for sc request
    if message.content.startswith('.sc search'):
        if message.channel == discord.utils.get(message.server.channels, name="testing", type=discord.ChannelType.text):
            temprequest = message.content.split(' ')
            temprequest.pop(0)
            temprequest.pop(0)
            global a, sql, tabid, tabac, tabarr, tabdep, tabnick
            try:
                if hasNumbers(temprequest[0]):  # if aircraft first arg
                    ac = temprequest[0]
                    if len(temprequest) > 1:  # if airport arg exists
                        airport = temprequest[1]
                    else:
                        airport = None
                else:  # if airport arg first
                    airport = temprequest[0]
                    if len(temprequest) > 1:  # if aircraft arg exists
                        ac = temprequest[1]
                    else:
                        ac = None
            except IndexError:
                airport = None
                ac = None

            if ac is not None:
                if len(ac) != 4:
                    msg = '{0.author.mention}, "' + ac + '" is not a valid aircraft ICAO code. A list of aircraft ICAO codes can be found at https://en.wikipedia.org/wiki/List_of_ICAO_aircraft_type_designators.'
                    await client.send_message(message.channel, msg.format(message))
            if airport is not None:
                if len(airport) != 4:
                    msg = '{0.author.mention}, "' + airport + '" is not a valid airport ICAO code. A list of airport ICAO codes can be found at http://www.airlinecodes.co.uk/aptcodesearch.asp.'
                    await client.send_message(message.channel, msg.format(message))

            a = conn.cursor()
            if ac is not None and airport is not None:
                sql = "SELECT * FROM requests WHERE (aircraft LIKE %s) and (dep LIKE %s or arr LIKE %s)"
                data = (ac, airport, airport)
                a.execute(sql, data)
            elif airport is not None:
                sql = "SELECT * FROM requests WHERE dep LIKE %s or arr LIKE %s"
                data = (airport, airport)
                a.execute(sql, data)
            elif ac is not None:
                sql = "SELECT * FROM requests WHERE aircraft LIKE %s"
                data = ac
                a.execute(sql, data)
            else:
                sql = 'SELECT * FROM `requests`'
                a.execute(sql)

            data = a.fetchall()
            tabid = []
            tabnick = []
            tabac = []
            tabdep = []
            tabarr = []
            for i in range(len(data)):
                rowmember = await client.get_user_info(user_id=data[i][1])
                rownick = rowmember.display_name
                tabid += ['' + str(data[i][0]).upper() + '']
                try:
                    tabnick += ['' + rownick + '']
                except TypeError:
                    tabnick += ['' + str(rowmember) + '']
                tabac += ['' + str(data[i][2]).upper() + '']
                tabdep += ['' + str(data[i][3]).upper() + '']
                tabarr += ['' + str(data[i][4]).upper() + '']

            tab.reset()
            if tabid:
                headings = ['ID', 'Nickname', 'A/C', 'Dep', 'Arr']
                tab.header(headings)
                for row in zip(tabid, tabnick, tabac, tabdep, tabarr):
                    tab.add_row(row)
                    tab.set_cols_align(["c", "c", "c", "c", "c"])
                s = tab.draw()
                msgstart = ':mag: **Search results:**\n```'
                msgend = '```'
                await client.send_message(message.channel, msgstart.format(message) + s.format(message) + msgend.format(message))
            else:
                msg = '{0.author.mention}, there are no results matching your search. Try broadening your search or add your own request.'
                await client.send_message(message.channel, msg.format(message))
        else:
            await client.delete_message(message)
            channel = client.get_channel(id="445686488164990986")
            msg = '{0.author.mention}, you may only use this command in the ' + channel.mention + ' channel.'
            await client.send_message(message.author, msg.format(message))

    # adding sc requests
    elif message.content.startswith('.sc add'):
        if message.channel == discord.utils.get(message.server.channels, name="testing", type=discord.ChannelType.text):
            temp = message.content.split(' ')
            a = conn.cursor()
            try:
                sql = "INSERT INTO requests (discord, aircraft, dep, arr)" "VALUES(%s, %s, %s, %s)"
                data = (message.author.id, temp[2], temp[3], temp[4])
                a.execute(sql, data)
                msg = '{0.author.mention}, your request is now in the system.\nInformation on your request is as follows:\n```\nAircraft   :  ' + temp[2] + '\nDeparture  :  ' + temp[3] + '\nArrival    :  ' + temp[4] + '```'
                await client.send_message(message.channel, msg.format(message))
            except IndexError:
                msg = '{0.author.mention}, there has been an error processing your request. Please make sure your request is in this format: `.sc add` `Aircraft Type` `Departure Airport` `Arrival Airport`'
                await client.send_message(message.channel, msg.format(message))
        else:
            await client.delete_message(message)
            channel = client.get_channel(id="445686488164990986")
            msg = '{0.author.mention}, you may only use this command in the ' + channel.mention + ' channel.'
            await client.send_message(message.author, msg.format(message))

    # accepting sc requests
    elif message.content.startswith('.sc accept'):
        if message.channel == discord.utils.get(message.server.channels, name="testing", type=discord.ChannelType.text):
            a = conn.cursor()
            sql = "SELECT * from accepted WHERE reqeustee = %s or acceptee = %s"
            data = (message.author.id, message.author.id)
            a.execute(sql, data)
            r = a.fetchall()
            if len(r) > 0:
                msg = '{0.author.mention}, you have already accepted a Shared Cockpit request meaning you can not accept a new one.'
                await client.send_message(message.author, msg.format(message))
                await client.delete_message(message)
            else:
                temp = message.content.split(' ')
                sql = "SELECT * FROM requests WHERE id = %s"
                data = temp[2]
                msg = '{0.author.mention}, enter the request ID ("' + temp[2] + '") again for confirmation'
                await client.send_message(message.channel, msg.format(message))
                await client.wait_for_message(author=message.author, content=temp[2])
                a.execute(sql, data)
                request = a.fetchone()
                requestee = await client.get_user_info(user_id=request[1])

                # message both the user accepting the request and the user who made the request
                await accept_msg(requestee, message.author, temp[2])
                sql = "INSERT INTO accepted (requestee, acceptee, aircraft, dep, arr)" "VALUES (%s, %s, %s, %s)"
                data = (requestee, message.author.id, request[2].upper(), request[3].upper(), request[4].upper())
                a.execute(sql, data)
                sql = "DELETE FROM requests WHERE id=%s"
                data = reqid
                a.execute(sql, data)
        else:
            await client.delete_message(message)
            channel = client.get_channel(id="445686488164990986")
            msg = '{0.author.mention}, you may only use this command in the ' + channel.mention + ' channel.'
            await client.send_message(message.author, msg.format(message))

    # delete sc request
    elif message.content.startswith('.sc delete'):
        if message.channel == discord.utils.get(message.server.channels, name="shared-cockpit", type=discord.ChannelType.text):
            temp = message.content.split(' ')
            a = conn.cursor()
            sql = "SELECT discord FROM requests WHERE id=%s"
            data = temp[2]
            a.execute(sql, data)
            reqdiscordid = a.fetchone()
            if message.author.id == reqdiscordid[0]:
                sql = "DELETE FROM requests WHERE id=%s"
                data = temp[2]
                a.execute(sql, data)
                msg = '{0.author.mention}, your request has been successfully deleted'
                await client.send_message(message.channel, msg.format(message))
            else:
                msg = '{0.author.mention}, you can only delete your own requests.'
                await client.send_message(message.channel, msg.format(message))
        await client.delete_message(message)

    # edit SC request
    elif message.content.startswith('.sc edit'):
        if message.channel == discord.utils.get(message.server.channels, name="testing", type=discord.ChannelType.text):
            temp = message.content.split(' ')
            a = conn.cursor()
            sql = "SELECT discord FROM requests WHERE id=%s"
            data = temp[2]
            a.execute(sql, data)
            reqdiscordid = a.fetchone()
            if message.author.id == reqdiscordid[0]:
                try:
                    sql = "UPDATE requests SET aircraft = %s, dep = %s, arr = %s WHERE id = %s"
                    data = (temp[3], temp[4], temp[5], temp[2])
                    a.execute(sql, data)
                    msg = '{0.author.mention}, your request has been successfully edited'
                    await client.send_message(message.channel, msg.format(message))
                except IndexError:
                    msg = '{0.author.mention}, there has been an error processing your request. Please make sure your request is in this format: `.sc edit` `Request ID` `Aircraft Type` `Departure Airport` `Arrival Airport`'
                    await client.send_message(message.channel, msg.format(message))
            else:
                msg = '{0.author.mention}, you can only edit your own requests.'
                await client.send_message(message.channel, msg.format(message))
        else:
            await client.delete_message(message)
            channel = client.get_channel(id="445686488164990986")
            msg = '{0.author.mention}, you may only use this command in the ' + channel.mention + ' channel.'
            await client.send_message(message.author, msg.format(message))

    # help with sc request commands
    elif message.content == '.sc help':
        if message.channel == discord.utils.get(message.server.channels, name="testing", type=discord.ChannelType.text):

            embed = discord.Embed(title="Shared Cockpit System - Commands", colour=discord.Colour(0x1), description="You can use the following commands with the MTC Copilot bot to make and accept shared cockpit flight requests.")

            embed.add_field(name=":mag: `.sc search (<aircraft> <airport>)`", value="Search for requests. `<aircraft>` and `<airport>` are optional arguments ***in ICAO code format***, and will filter requests by aircraft and/or departure/arrival airport.")
            embed.add_field(name=":heavy_plus_sign: `.sc add <aircraft> <dep> <arr>`", value="Add a request. All arguments are required  ***in ICAO code format***.")
            embed.add_field(name=":pencil2: `.sc edit <id> <new aircraft> <new dep> <new arr>`", value="Edit a request. `<id>` is the ID of the request you wish to edit (you can only edit your own requests), and the other arguments are all required.")
            embed.add_field(name=":no_entry_sign: `.sc delete <id>`", value="Delete a request . `<id>` is the ID of the request you wish to delete (you can only delete your own requests)")
            embed.add_field(name=":white_check_mark: `.sc accept <id>`", value="Accept a request. `<id>` is the ID of the request you wish to select, which can be found using the search command")

            await client.send_message(message.channel, embed=embed)
        else:
            await client.delete_message(message)
            channel = client.get_channel(id="445686488164990986")
            msg = '{0.author.mention}, you may only use this command in the ' + channel.mention + ' channel.'
            await client.send_message(message.author, msg.format(message))

    # clear all messages in sc channel
    elif message.content.startswith('.clear'):
        if "440550777912819712" in [role.id for role in message.author.roles]:
            if message.channel == discord.utils.get(message.server.channels, name="shared-cockpit", type=discord.ChannelType.text):
                async for msg in client.logs_from(message.channel):
                    await client.delete_message(msg)


# clear data from requests table every 48 hours
async def requests_clear():
    await client.wait_until_ready()
    while not client.is_closed:
        await asyncio.sleep(172800)
        conn = pymysql.connect(host='localhost', user='discord', password='s+pq4fN@2J@VeGkY+V#ry-Hy', db='discord', autocommit=True)
        b = conn.cursor()
        sqldel = 'TRUNCATE TABLE `requests`'
        b.execute(sqldel)


@client.event
async def on_ready():
    await client.change_presence(game=discord.Game(name='multicrew.co.uk'))
    print('Logged in as')
    print(client.user.name)
    print(client.user.id)
    print('------')
    asyncio.run_coroutine_threadsafe(asyncio.start_server(socket_server, '127.0.0.1', 9000), client.loop)


client.loop.create_task(requests_clear())
client.run('NDQ1NjkxNDAzNTc4NzY5NDEx.Di0F4w.nVl4Hs0lp_ugxY5esa8YfMCOXJc')
