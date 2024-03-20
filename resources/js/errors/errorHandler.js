export function handleErrorResponse(error) {
  // console.log(error.response.data.message);
  if (error.response && error.response.status === 500) {
    toastr.error(error.response.data.message);
    this.playSound();
  } else if (error.response && error.response.status !== 422) {
    toastr.error(error.response.data.message);
    this.playSound();
  }
  if (error.response && error.response.status === 422) {
    this.allErrors.record(error.response.data.errors);
    this.playSound();
  }
}
