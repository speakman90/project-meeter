import React, { useState, useEffect } from 'react';
import axios from 'axios';
import TextField from '@mui/material/TextField';
import Autocomplete from '@mui/material/Autocomplete';
import CircularProgress from '@mui/material/CircularProgress';
import Button from '@mui/material/Button';
import { createRoot } from 'react-dom/client';

function sleep(delay = 0) {
  return new Promise((resolve) => {
    setTimeout(resolve, delay);
  });
}

function ComboBox() {
  const [open, setOpen] = useState(false);
  const [value, setValue] = useState('');
  const [inputValue, setInputValue] = useState('');
  const [activity, setActivity] = useState({});
  const loading = open && activity.length === 0;

    useEffect(() => {
      let active = true;
      if (!loading) {
        return undefined;
      }
      sleep(100);
      fetch(`http://localhost/api/v1/getActivities`)
      .then(res => res.json())
      .then(response => {
        setActivity(response)
      })
             
      return () => {
        active = false;
      };
      }, [loading]);

    useEffect(() => {
      if (!open) {
        setActivity([]);
      }
    }, [open]);

    let handleSubmit = async (e) => {
      e.preventDefault();
      try {
        axios({
          method: 'post',
          url: '/api/v1/addActivities',
          headers: {
            'Content-Type': 'multipart/form-data',
            'Accept': 'multipart/form-data'
          },
          data: {
            id: value.id
          }
        }).then(function (response) {
          if(response.status === 200) {location.reload()};
        });
      } catch (err) {
        console.log(err);
      }
        }

  return (
    <>
      <Autocomplete
        id="combo-box-demo"
        options={activity}
        open={open}
        value={value}
        onChange={(event, newValue) => {
          setValue(newValue);
        }}
        inputValue={inputValue}
        onInputChange={(event, newInputValue) => {
          setInputValue(newInputValue);
        }}
        onOpen={() => {
          setOpen(true);
        }}
        onClose={() => {
          setOpen(false);
        }}
        getOptionLabel={(option) => option.name || ""}
        renderInput={(params) => <TextField {...params} label="Activité"
        InputProps={{
          ...params.InputProps,
          endAdornment: (
            <React.Fragment>
              {loading ? <CircularProgress color="inherit" size={20} /> : null}
              {params.InputProps.endAdornment}
            </React.Fragment>
          ),
        }} />}
      />
      <Button
          onClick={handleSubmit}
          variant="contained"
        >
        Ajouter 
      </Button>
    </>
  );
}

const Dom = document.getElementById('activities') ? document.getElementById('activities') : null

const root = Dom ? createRoot(Dom) : null;

root ? root.render(<ComboBox />) : null;
