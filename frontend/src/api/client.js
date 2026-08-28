import axios from 'axios';

const config = window.miniAssessmentConfig || {
  apiUrl: '/wp-json/assessment/v1',
  nonce: '',
  isLoggedIn: false,
  canManage: false,
  siteUrl: ''
};

const apiClient = axios.create({
  headers: {
    'Content-Type': 'application/json',
    'X-WP-Nonce': config.nonce
  }
});

// Keep WordPress's query-style rest_route intact when pretty permalinks are off.
export const apiEndpoint = (path = '') => `${config.apiUrl.replace(/\/$/, '')}/${path.replace(/^\//, '')}`;

apiClient.interceptors.response.use(
  (response) => response.data.data,
  (error) => {
    const status = error.response?.status || 500;
    const payload = error.response?.data || {};
    const message = payload.message || 'Loi ket noi may chu.';
    return Promise.reject({ status, message, raw: payload });
  }
);

export { config };
export default apiClient;
