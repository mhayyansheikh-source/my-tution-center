const WP_API_URL = `${import.meta.env.PUBLIC_WP_API_URL}/wp/v2`;

export async function fetchAPI(endpoint) {
  const res = await fetch(`${WP_API_URL}/${endpoint}`);
  
  if (!res.ok) {
    console.error(`Failed to fetch from WP API: ${res.status} ${res.statusText}`);
    return [];
  }
  
  const json = await res.json();
  return json;
}

export async function getCourses() {
  return await fetchAPI('course?_embed');
}

export async function getTutors() {
  return await fetchAPI('tutor_profile?_embed');
}
