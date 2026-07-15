const WP_BASE = import.meta.env.PUBLIC_WP_API_URL;
const WP_API_URL = WP_BASE ? `${WP_BASE}/wp/v2` : null;

export async function fetchAPI(endpoint) {
  if (!WP_API_URL) {
    console.warn('PUBLIC_WP_API_URL not set — returning empty data.');
    return [];
  }

  const url = `${WP_API_URL}/${endpoint}`;
  let res;
  try {
    res = await fetch(url);
  } catch {
    console.warn(`Failed to fetch from WP API: network error`);
    return [];
  }

  if (!res.ok) {
    console.warn(`Failed to fetch from WP API: ${res.status} ${res.statusText}`);
    return [];
  }
  
  const json = await res.json();
  return json;
}

export async function getCourses() {
  return await fetchAPI('course?_embed');
}

export async function getCourseBySlug(slug) {
  const courses = await fetchAPI(`course?slug=${slug}&_embed`);
  return courses?.[0] || null;
}

export async function getTutors() {
  return await fetchAPI('tutor_profile?_embed');
}
