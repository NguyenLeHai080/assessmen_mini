import apiClient, { apiEndpoint } from './client';

export const assessmentService = {
  getAssessments: (page = 1, perPage = 10) => apiClient.get(apiEndpoint('assessments'), { params: { page, per_page: perPage } }),
  getAssessment: (id) => apiClient.get(apiEndpoint(`assessments/${id}`)),
  createAssessment: (data) => apiClient.post(apiEndpoint('assessments'), data),
  updateAssessment: (id, data) => apiClient.post(apiEndpoint(`assessments/${id}`), data),
  deleteAssessment: (id) => apiClient.delete(apiEndpoint(`assessments/${id}`)),
  getQuestions: (assessmentId) => apiClient.get(apiEndpoint(`assessments/${assessmentId}/questions`)),
  createQuestion: (data) => apiClient.post(apiEndpoint('questions'), data),
  createAnswer: (data) => apiClient.post(apiEndpoint('answers'), data),
  submitAssessment: (id, answers) => apiClient.post(apiEndpoint(`assessments/${id}/submissions`), { answers })
};
