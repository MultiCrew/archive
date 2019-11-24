import sys
import socket
import os
import asyncio


async def web_accept(reqid, discid):
    print(reqid)
    print(discid)


async def socket_server(reader, writer):

    print("Server Started")
    data = await reader.read(100)
    message = data.decode()
    dataarray = message.split(',')
    if dataarray[0] == "copilot":
        await web_accept(dataarray[1], dataarray[2])
    # addr = writer.get_extra_info('peername')
    # print("Received %r from %r" % (message, addr))

    # print("Send: %r" % message)
    # writer.write(data)
    # await writer.drain()

    writer.close()

    # await client.wait_until_ready()
    # while not client.is_closed:
    #    await asyncio.sleep(1)
    #    serverSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # create UDP socket
    #    serverSocket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    #    serverSocket.bind(('127.0.0.1', 9000))
    #    print("Server Connected")

    #    serverSocket.listen(1)  # listen for connections, max. non-accepted connections set to 1
    #    connection, address = serverSocket.accept()  # accept a connection (blocking)
    #    print("Connected to %s on %s" % (address[0], address[1]))

    #    try:
    #        data = connection.recv(1024)

    #        if data:
    #            decoded = data.decode()
    #            dataarray = decoded.split(',')
    #            if dataarray[0] == "copilot":
    #                await web_accept(dataarray[1], dataarray[2])
    #            else:
    #                return

    #    except socket.error as msg:
    #        print("Server disconnected")
    #        connection.close()  # close the socket connection

    #    serverSocket.close()  # close the socket



#loop = asyncio.get_event_loop()
# coro = asyncio.start_server(socket_server, '127.0.0.1', 9000, loop=loop)
# server = loop.run_until_complete(coro)
# try:
#    loop.run_forever()
# except KeyboardInterrupt:
#    pass
# server.close()
# loop.run_until_complete(server.wait_closed())
# loop.close()
