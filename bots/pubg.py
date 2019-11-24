import discord
import re

client = discord.Client()


@client.event
async def on_message(message):
    if message.content.startswith('!squad'):
        channel = discord.utils.get(message.server.channels, name='Squads-'+ message.author.name)
        if channel:
            await client.delete_message(message)
        else:
            embed = discord.Embed(title="Squads", colour=discord.Colour(0xff9500))
            embed.add_field(name="Creator", value=message.author.mention, inline=False)
            sentmessage = await client.send_message(message.channel, embed=embed)
            await client.add_reaction(message=sentmessage, emoji="\U00002705")
            await client.add_reaction(message=sentmessage, emoji="❌")
            everyone = discord.PermissionOverwrite(connect=False)
            creator = discord.PermissionOverwrite(connect=True)
            createdchannel = await client.create_channel(message.server, 'Squad-' + message.author.name, (message.server.default_role, everyone), (message.author, creator), type=discord.ChannelType.voice)
            await client.edit_channel(createdchannel, user_limit=4, parent_id=491976228350197760)

    elif message.content.startswith('!duo'):
        channel = discord.utils.get(message.server.channels, name='Duo-' + message.author.name)
        if channel:
            await client.delete_message(message)
        else:
            embed = discord.Embed(title="Duo", colour=discord.Colour(0xff9500))
            embed.add_field(name="Creator", value=message.author.mention, inline=False)
            sentmessage = await client.send_message(message.channel, embed=embed)
            await client.add_reaction(message=sentmessage, emoji="\U00002705")
            await client.add_reaction(message=sentmessage, emoji="❌")
            everyone = discord.PermissionOverwrite(connect=False)
            creator = discord.PermissionOverwrite(connect=True)
            createdchannel = await client.create_channel(message.server, 'Duo-' + message.author.name, (message.server.default_role, everyone), (message.author, creator), type=discord.ChannelType.voice)
            await client.edit_channel(createdchannel, user_limit=2, parent_id=491976228350197760)

    elif message.content.startswith('!solo'):
        channel = discord.utils.get(message.server.channels, name='Solo-' + message.author.name)
        if channel:
            await client.delete_message(message)
        else:
            embed = discord.Embed(title="Solo", colour=discord.Colour(0xff9500))
            embed.add_field(name="Creator", value=message.author.mention, inline=False)
            sentmessage = await client.send_message(message.channel, embed=embed)
            await client.add_reaction(message=sentmessage, emoji="❌")
            everyone = discord.PermissionOverwrite(connect=False)
            creator = discord.PermissionOverwrite(connect=True)
            createdchannel = await client.create_channel(message.server, 'Solo-' + message.author.name, (message.server.default_role, everyone), (message.author, creator), type=discord.ChannelType.voice)
            await client.edit_channel(createdchannel, user_limit=1, parent_id=491976228350197760)


@client.event
async def on_reaction_add(reaction, user):
    if user != client.user:
        if reaction.emoji == "\U00002705":
            if user.mention != reaction.message.embeds[0]['fields'][0]['value']:
                embed = discord.Embed(title=reaction.message.embeds[0]['title'], colour=discord.Colour(0xff9500))
                if reaction.message.embeds[0]['title'] == "Squads":
                    i = 0
                    try:
                        while reaction.message.embeds[0]['fields'][i]:
                            if i == 0:
                                embed.add_field(name="Creator", value=reaction.message.embeds[0]['fields'][i]['value'])
                                i += 1
                            elif i <= 2:
                                embed.add_field(name='Player'+str(i), value=reaction.message.embeds[0]['fields'][i]['value'])
                                i += 1
                            else:
                                break

                    except IndexError:
                        embed.add_field(name=str('New Player'), value=str(user.mention))
                        await client.edit_message(reaction.message, embed=embed)
                        newplayer = discord.PermissionOverwrite(connect=True)
                        char_list = ['<', '@', '>']
                        id = re.sub("|".join(char_list), "", reaction.message.embeds[0]['fields'][0]['value'])
                        channel = discord.utils.get(client.get_server("491975201651687424").channels, name=reaction.message.embeds[0]['title'] + '-' + (discord.utils.get(client.get_server("491975201651687424").members, id=id).name))
                        await client.edit_channel_permissions(channel, target=user, overwrite=newplayer)

                elif reaction.message.embeds[0]['title'] == "Duo":
                    i = 0
                    try:
                        while reaction.message.embeds[0]['fields'][i]:
                            if i == 0:
                                embed.add_field(name="Creator", value=reaction.message.embeds[0]['fields'][i]['value'])
                                i += 1
                            else:
                                break

                    except IndexError:
                        embed.add_field(name=str('New Player'), value=str(user.mention))
                        await client.edit_message(reaction.message, embed=embed)
                        newplayer = discord.PermissionOverwrite(connect=True)
                        char_list = ['<','@','>']
                        id = re.sub("|".join(char_list), "", reaction.message.embeds[0]['fields'][0]['value'])
                        channel = discord.utils.get(client.get_server("491975201651687424").channels, name=reaction.message.embeds[0]['title'] + '-' + (discord.utils.get(client.get_server("491975201651687424").members, id=id).name))
                        await client.edit_channel_permissions(channel, target=user, overwrite=newplayer)

                elif reaction.message.embeds[0]['title'] == "Solo":
                    await client.remove_reaction(reaction.message, member=discord.utils.get(client.get_server("491975201651687424").members, id=user.id), emoji="\U00002705")

        elif reaction.emoji == "❌":
            if user.mention == reaction.message.embeds[0]['fields'][0]['value']:
                await client.delete_message(reaction.message)
                channel = discord.utils.get(client.get_server("491975201651687424").channels, name=reaction.message.embeds[0]['title']+'-'+user.name)
                await client.delete_channel(channel)
            else:
                await client.remove_reaction(reaction.message, member=(discord.utils.get(client.get_server("491975201651687424").members, id=user.id)), emoji="❌")

@client.event
async def on_reaction_remove(reaction, user):
    removeplayer = discord.PermissionOverwrite(connect=False)
    char_list = ['<', '@', '>']
    id = re.sub("|".join(char_list), "", reaction.message.embeds[0]['fields'][0]['value'])
    channel = discord.utils.get(client.get_server("491975201651687424").channels, name=reaction.message.embeds[0]['title'] + '-' + (discord.utils.get(client.get_server("491975201651687424").members, id=id).name))
    await client.edit_channel_permissions(channel, target=user, overwrite=removeplayer)

@client.event
async def on_ready():
    await client.change_presence(game=discord.Game(name="PLAYERUNKNOWN'S BATTLEGROUNDS"))
    print('Logged in as')
    print(client.user.name)
    print(client.user.id)
    print('------')


client.run('NDkyMjY5MDgzNDA0Nzk1OTA1.DoT9og.burIrJCwTFrHbTtD_WRVrI7eP_E')
