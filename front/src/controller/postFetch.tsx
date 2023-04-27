export async function postFetch(url: string, data: any) {
  try {
    const response = await fetch(`http://localhost:3200${url}`, {
      method: 'POST',
      mode: 'cors',
      body: JSON.stringify(data),
    });
    const json = await response.json();
    return json;
  } catch (error) {
    console.log(error);
    return false;
  }
}
