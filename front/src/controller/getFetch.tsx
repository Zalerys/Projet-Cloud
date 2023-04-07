export async function getFetch(url: string) {
  try {
    const response = await fetch(`http://localhost:3500${url}`);
    if (!response.ok) {
      throw new Error(response.statusText);
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
