async function fetchPharmacyData() {
    try {
      const response = await axios.get(`/setting/general-info`);
      const companyInfo = response.data.result;
      localStorage.setItem('company', JSON.stringify(companyInfo));
    } catch (error) {
      console.error('Error fetching pharmacy data:', error);
    }
  }
export default {
    created() {
        const companyInfoString = localStorage.getItem('company');
        const companyinfo = companyInfoString  ? JSON.parse(companyInfoString) : null;
        if (companyinfo === null) {
            fetchPharmacyData.call(this);
            const companyInfoString = JSON.parse(localStorage.getItem('company'));
            this.companyInfo = companyInfoString;
        }else{
          this.companyInfo = companyinfo;
        }
    },
  };