import * as React from 'react';
import { Link } from 'react-router-dom'
import Box from '@mui/material/Box';
import Stepper from '@mui/material/Stepper';
import Step from '@mui/material/Step';
import StepLabel from '@mui/material/StepLabel';
import Button from '@mui/material/Button';
import Typography from '@mui/material/Typography';

export default function HorizontalLinearStepper() {
  const [activeStep, setActiveStep] = React.useState(0);
  const [skipped, setSkipped] = React.useState(new Set());
  const [count, setCount] = React.useState(200);
  const [bio, setBio] = React.useState("");
  const [genre, setGenre] = React.useState([1]);
  const [profil, setProfil] = React.useState([]);

  const handleFileEvent =  (e) => {
      console.log(e.target.files)
      setProfil(e.target.files)
  }
  
  let handleSubmit = async (e) => {
    e.preventDefault();
    try {
      let res = await fetch("http://localhost/api/v1/register", {
        method: "POST",
        body: JSON.stringify({
          bio: bio,
          orientation: genre,
          profilPicture: profil
        })
      });
      let resJson = await res.json();
      if (res.status === 200) {
        setMessage("Ok");
      } else {
        setMessage("Some error occured");
      }
    } catch (err) {
      console.log(err);
    }
  };

  const isStepOptional = (step) => {
    return step === 1;
  };

  const isStepSkipped = (step) => {
    return skipped.has(step);
  };

  const handleNext = () => {
    let newSkipped = skipped;
    if (isStepSkipped(activeStep)) {
      newSkipped = new Set(newSkipped.values());
      newSkipped.delete(activeStep);
    }

    setActiveStep((prevActiveStep) => prevActiveStep + 1);
    setSkipped(newSkipped);
  };

  const handleBack = () => {
    setActiveStep((prevActiveStep) => prevActiveStep - 1);
  };

  const handleReset = () => {
    setActiveStep(0);
  };

  const countCharacter = (e) => {
    setCount(200 - e.target.value.length)
  };

  const handleBio = (e) => {
    setBio(e.target.value)
  }

  const handleOnChange = (e) => {
    countCharacter(e)
    handleBio(e)
  };

  const steps = [
    {
      label: 'Parle nous de toi !',
      description: 
        <div className="mb-6">
          <label htmlFor="bio" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Votre bios // {count}/200 caractères restants</label>
          <textarea id="bio" name='bio' onChange={(e) => handleOnChange(e)} rows="4" className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
        </div>
    },
    {
      label: 'Que recherche tu ?',
      description:
        <div className="mb-6">
          <label htmlFor="genre" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Identité de genre que vous recherchez</label>
          <select id="genre" name="genre" defaultValue="1" onChange={(e) => setGenre(e.target.value)} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected value='1'></option>
            <option value='1'>Homme</option>
            <option value='2'>Femme</option>
          </select>
        </div>
    },
    {
      label: 'Create an ad',
      description: 
        <div className="flex items-center justify-center w-full">
            <label htmlFor="profil" className="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div className="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg aria-hidden="true" className="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p className="mb-2 text-sm text-gray-500 dark:text-gray-400"><span className="font-semibold">Clique</span> ou drag and drop pour ajouté des photos de profil</p>
                    <p className="text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. 6 photos)</p>
                </div>
                <input id="profil" name="profil" type="file" className="hidden" onChange={handleFileEvent} accept="image/png, image/jpeg" multiple />
            </label>
        </div> 
    },
  ];

  return (
    <Box sx={{ width: '100%' }}>
      <Stepper activeStep={activeStep}>
        {steps.map((step, index) => {
          return (
            <Step key={step.label}>
              <StepLabel>{step.label}</StepLabel>
            </Step>
          );
        })}
      </Stepper>
      {activeStep === steps.length ? (
        <React.Fragment>
          <Typography sx={{ mt: 2, mb: 1 }}>
            Votre inscription est finito !
          </Typography>
          <Box sx={{ display: 'flex', flexDirection: 'row', pt: 2 }}>
            <Box sx={{ flex: '1 1 auto' }} />
            <Link to="/profil" className="btn btn-primary" onClick={handleSubmit}>Découvre le nouveau monde</Link>
          </Box>
        </React.Fragment>
      ) : (
        <React.Fragment>
          <form>
            { steps[activeStep].description }
          </form>
          <Box sx={{ display: 'flex', flexDirection: 'row', pt: 2 }}>
            <Button
              color="inherit"
              disabled={activeStep === 0}
              onClick={handleBack}
              sx={{ mr: 1 }}
            >
              Retour en arrière
            </Button>
            <Box sx={{ flex: '1 1 auto' }} />
            <Button onClick={handleNext}>
              {activeStep === steps.length - 1 ? "C'est tout bon ?" : 'Suivant'}
            </Button>
          </Box>
        </React.Fragment>
      )}
    </Box>
  );
}