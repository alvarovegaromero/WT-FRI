"""An example of a simple HTTP server."""
import json
import mimetypes
import pickle
import socket
from os import listdir
from os.path import isdir, isfile, join
from urllib.parse import unquote_plus

# Pickle file for storing data
PICKLE_DB = "db.pkl"

# Directory containing www data
WWW_DATA = "www-data"

# Represents a table row that holds user data
TABLE_ROW = """
<tr>
    <td>%d</td>
    <td>%s</td>
    <td>%s</td>
</tr>
"""

# Header template for a successful HTTP request
HEADER_RESPONSE_200 = """HTTP/1.1 200 OK\r
Content-type: %s\r
Content-length: %d\r
Connection: Close\r
\r
"""

# Header template for a moved permanently response message 
HEADER_RESPONSE_301 = """HTTP/1.1 301 Moved Permanently\r
Location: %s\r
\r"""

# Template for a 400 (Bad Request) error
RESPONSE_400 = """HTTP/1.1 400 Bad Request\r
Content-Type: text/plain\r
\r
The request does not follow the specifications"""

# Template for a 404 (Not found) error
RESPONSE_404 = """HTTP/1.1 404 Not found\r
Content-type: text/html\r
Connection: Close\r
\r
<!doctype html>
<h1>404 Page not found</h1>
<p>Page cannot be found.</p>
"""

# Template for a 405 (Method Not Allowed) error
RESPONSE_405 = """HTTP/1.1 405 Method Not Allowed\r
Content-Type: text/plain\r
Allow: GET, POST\r
\r
The specified HTTP method is not allowed. Only GET and POST methods are allowed."""

DIRECTORY_LISTING = """<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Directory listing: %s</title>

<h1>Contents of %s:</h1>

<ul>
{{CONTENTS}}
</ul> 
"""

FILE_TEMPLATE = "  <li><a href='%s'>%s</li> \n "


def save_to_db(first, last):
    """Create a new user with given first and last name and store it into
    file-based database.

    For instance, save_to_db("Mick", "Jagger"), will create a new user
    "Mick Jagger" and also assign him a unique number.

    Do not modify this method."""

    existing = read_from_db()
    existing.append({
        "number": 1 if len(existing) == 0 else existing[-1]["number"] + 1,
        "first": first,
        "last": last
    })
    with open(PICKLE_DB, "wb") as handle:
        pickle.dump(existing, handle)


def read_from_db(criteria=None):
    """Read entries from the file-based DB subject to provided criteria

    Use this method to get users from the DB. The criteria parameters should
    either be omitted (returns all users) or be a dict that represents a query
    filter. For instance:
    - read_from_db({"number": 1}) will return a list of users with number 1
    - read_from_db({"first": "bob"}) will return a list of users whose first
    name is "bob".

    Do not modify this method."""
    if criteria is None:
        criteria = {}
    else:
        # remove empty criteria values
        for key in ("number", "first", "last"):
            if key in criteria and criteria[key] == "":
                del criteria[key]

        # cast number to int
        if "number" in criteria:
            criteria["number"] = int(criteria["number"])

    try:
        with open(PICKLE_DB, "rb") as handle:
            data = pickle.load(handle)

        filtered = []
        for entry in data:
            predicate = True

            for key, val in criteria.items():
                if val != entry[key]:
                    predicate = False

            if predicate:
                filtered.append(entry)

        return filtered
    except (IOError, EOFError):
        return []


def process_request(connection, address, port):
    """Process an incoming socket request.

    :param connection is a socket of the client
    :param address is a 2-tuple (address(str), port(int)) of the client
    """

    # Read and parse the request line

    client = connection.makefile("wrb")
    line = client.readline().decode("utf-8").strip()

    try:
        method, uri, version = line.split()
    except ValueError:
        # Send a "400 Bad Request" response
        client.write(RESPONSE_400.encode("utf-8"))
        client.close()
        return

    if method not in ("GET", "POST"):
        # Send a "405 Method Not Allowed" response
        client.write(RESPONSE_405.encode("utf-8"))
        client.close()
        return
    
    # Read and parse headers

    headers = parse_headers(client)

    print(method, uri, version, headers)

    # Read and parse the body of the request (if applicable),
    # Create the response and
    # Write the response back to the socket 

    # Check if the request is for adding a student to the database
    if method == "POST":    
        with open("www-data/app_add.html", "rb") as file:
            resource = file.read()

        response_headers = HEADER_RESPONSE_200 % ("text/html", len(resource))
        client.write(response_headers.encode("utf-8"))
        client.write(resource)
        
    else:
        # Handle requests for serving files/directories
        try:
            assert len(uri) > 0 and uri[0] == "/", "Invalid uri"

            file_path = "/www-data" + uri

            if isfile(file_path[1:]):
                # If the URI points to a file, give it to the client
                with open(file_path[1:], "rb") as file:
                    resource = file.read()

                mime, _ = mimetypes.guess_type(uri)
                response_headers = HEADER_RESPONSE_200 % (mime, len(resource))

                client.write(response_headers.encode("utf-8"))
                client.write(resource)
            elif isdir(file_path[1:]):
                if uri[-1] == "/": # last character is a /
                    index_file = file_path[1:] + "index.html"
                    if isfile(index_file): #if index.html exists, serve it
                        with open(index_file, "rb") as file:
                            resource = file.read()

                        mime, _ = mimetypes.guess_type(uri)
                        response_headers = HEADER_RESPONSE_200 % (mime, len(resource))  

                        client.write(response_headers.encode("utf-8"))
                        client.write(resource)
                    else:
                        # serve directory list
                        files = listdir(file_path[1:])
                        files.sort()

                        file_links = ""
                        for file in files: #add link to every file or dir
                            #if isfile(file_path[1:] + file):
                            #elif isdir(file_path[1:] + file):
    
                            link = FILE_TEMPLATE % (file, file)

                            file_links += link

                        if uri != "/": #add parent directory 
                            file_links = FILE_TEMPLATE % ("..", "..") + file_links #+ to keep old data

                        html = DIRECTORY_LISTING.replace('{{CONTENTS}}', file_links) % (file_path[9:], file_path[9:])
                        response_headers = HEADER_RESPONSE_200 % ("text/html", len(html))

                        client.write(response_headers.encode("utf-8"))
                        client.write(html.encode("utf-8"))
                else: #ends without trailing slash --> redirect 
                    new_location = "http://localhost:%d%s/" % (port, uri)
                    response_headers = HEADER_RESPONSE_301 % new_location

                    client.write(response_headers.encode("utf-8"))
            else:
                # return error 404 if the URI is not redirecting to a directory or file
                client.write(RESPONSE_404.encode("utf-8"))

        except (ValueError, AssertionError) as e:
            print("Invalid request line '%s' : %s" % (line, e))
        except FileNotFoundError:
            client.write(RESPONSE_404.encode("utf-8"))
        finally:
            client.close()

def parse_headers(client):
    headers = {}

    while True:
        line = client.readline().decode('utf-8').strip()
        if not line: #we found the empty line
            return headers
        key, value = line.split(":", 1)
        headers[key.strip()] = value.strip()

#used for getting the parameters from the POST request
def parse_body(client, headers):
    content_length = int(headers.get('Content-Length', 0))
    body = client.read(content_length).decode('utf-8')
    params = {}
    for param in body.split('&'):
        key, value = param.split('=')
        params[key] = value
    return params

def main(port):
    """Starts the server and waits for connections."""

    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server.bind(("", port))
    server.listen(1)

    print("Listening on %d" % port)

    while True:
        connection, address = server.accept()
        print("[%s:%d] CONNECTED" % address)
        process_request(connection, address, port)
        connection.close()
        print("[%s:%d] DISCONNECTED" % address)


if __name__ == "__main__":
    main(8080)
