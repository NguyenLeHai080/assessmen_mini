import apiClient from './client';

export const assessmentService = {
  getAssessments: (page = 1, perPage = 10) => apiClient.get(`/assessments?page=${page}&per_page=${perPage}`),
  getAssessment: (id) => apiClient.get(`/assessments/${id}`),
  createAssessment: (data) => apiClient.post('/assessments', data),
  updateAssessment: (id, data) => apiClient.post(`/assessments/${id}`, data),
  deleteAssessment: (id) => apiClient.delete(`/assessments/${id}`),
  getQuestions: (assessmentId) => apiClient.get(`/assessments/${assessmentId}/questions`),
  createQuestion: (data) => apiClient.post('/questions', data),
  createAnswer: (data) => apiClient.post('/answers', data)
};
