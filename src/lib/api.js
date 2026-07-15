const WP_API_URL = 'https://api.mytuitioncenter.pk/wp-json/wp/v2'; // Pointing to production live WordPress domain

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
