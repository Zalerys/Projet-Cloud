export async function postFetchToken(url: string, data: any, token: any) {
  try {
    const response = await fetch(`http://localhost:3200${url}`, {
      method: 'POST',
      mode: 'cors',
      headers: {
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + token,
      },
      body: JSON.stringify(data),
    });
    const json = await response.json();
    return json;
  } catch (error) {
    console.log(error);
    return false;
  }
}
