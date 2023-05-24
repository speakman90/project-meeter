import React, { useState } from 'react';
import axios from 'axios';
import TextField from '@mui/material/TextField';
import Autocomplete from '@mui/material/Autocomplete';
import { createRoot } from 'react-dom/client';

function ComboBox() {
    const [activity, setActivity] = useState([])

    axios.get(`http://localhost/api/v1/getActivities`)
    .then(res => {
        const persons = res.data;
        setActivity(persons);
    });
    
    console.log(activity);

  return (
    <Autocomplete
      disablePortal
      id="combo-box-demo"
      options={activity}
      sx={{ width: 300 }}
      renderInput={(params) => <TextField {...params} label="Movie" />}
    />
  );
}

const root = createRoot(
    document.getElementById('activities')
  );
root.render(<ComboBox />);
