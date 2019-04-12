package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.apache.commons.io.FileUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

public class SelectNotes extends AppCompatActivity implements View.OnClickListener, AdapterView.OnItemSelectedListener {

    Spinner branch_spinner, sem_spinner,subject_spinner,course_spinner;
    Button view_your_notes,search;
    String offline_note_list="";
    String roll;
    ProgressDialog pd;
    String course_select="",branch_select="",sem_select="",subject_select="";
    JSONArray courses_json,branch_json,sem_json,subjects_json;
    ArrayList<String> course = new ArrayList<>();
    ArrayList<String> branch = new ArrayList<>();
    ArrayList<String> subject = new ArrayList<>();
    ArrayList<String> sem = new ArrayList<>();
    ArrayAdapter<String> adapter1;
    ArrayAdapter<String> adapter2;
    ArrayAdapter<String>adapter3;
    ArrayAdapter<String>adapter4;
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                SelectNotes.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select_notes);
        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();
        branch_spinner = (Spinner) findViewById(R.id.spinner_notes_branch);
        sem_spinner = (Spinner) findViewById(R.id.spinner_notes_sem);
        subject_spinner = (Spinner) findViewById(R.id.spinner_notes_subject);
        course_spinner = (Spinner) findViewById(R.id.spinner_notes_course);
        view_your_notes = (Button) findViewById(R.id.view_your_notes);
        search = (Button) findViewById(R.id.search_notes);
        view_your_notes.setOnClickListener(this);
        search.setOnClickListener(this);
        roll = getIntent().getStringExtra("roll");
       readItems();
        TextView tv = (TextView) findViewById(R.id.select_notes_appbar);
        Typeface custom_font1 = Typeface.createFromAsset(getAssets(), "fonts/TitilliumWeb-Light.ttf");
        tv.setTypeface(custom_font1);
        if(!offline_note_list.equalsIgnoreCase("")){
            String[] fadu_data = offline_note_list.split("``%f%``");
            course.clear();
            branch.clear();
            sem.clear();
            subject.clear();
            try {
                courses_json =new JSONArray(fadu_data[0]);
                subjects_json = new JSONArray(fadu_data[2]);
                branch_json=new JSONArray(fadu_data[3]);
                sem_json=new JSONArray(fadu_data[1]);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            for(int i=0;i<courses_json.length();i++)
            {
                JSONObject obj= courses_json.optJSONObject(i);
                course.add(obj.optString("course"));
            }
            adapter2 = new ArrayAdapter<String>(SelectNotes.this,
                    R.layout.custom_spinner,course);

            adapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            course_spinner.setAdapter(adapter2);
            course_spinner.setOnItemSelectedListener(this);
        }
        else{

        if(isNetworkAvailable()){
        final select_Class_Loader select_class_loader = new select_Class_Loader(SelectNotes.this);
        select_class_loader.execute();

            Handler handler = new Handler();
            handler.postDelayed(new Runnable()
            {
                @Override
                public void run() {
                    if ( select_class_loader.getStatus() == AsyncTask.Status.RUNNING )
                    {select_class_loader.cancel(true);
                        Toast.makeText(SelectNotes.this, "Time OUT", Toast.LENGTH_SHORT).show();
                        if(pd.isIndeterminate())
                        pd.dismiss();
                    }
                }
            }, 20000 );
        }
        else {
           Toast.makeText(this, "Please Connect To Internet", Toast.LENGTH_SHORT).show();
       }}
    }
    @Override
    public void onClick(View view) {
        switch (view.getId())
        {
            case R.id.view_your_notes:{
                Intent i = new Intent(SelectNotes.this,ViewNotes.class);
                i.putExtra("roll",roll);
                i.putExtra("your","1");
                i.putExtra("branch","");
                i.putExtra("sem","");
                i.putExtra("subject","");
                i.putExtra("course","");
                startActivity(i);
                break;
            }
            case R.id.search_notes:{
                if(!branch_select.equalsIgnoreCase("")&&!course_select.equalsIgnoreCase("")&&!subject_select.equalsIgnoreCase("")&&!sem_select.equalsIgnoreCase("")){
                Intent i = new Intent(SelectNotes.this,ViewNotes.class);
                i.putExtra("roll",roll);
                i.putExtra("your","0");
                i.putExtra("branch",branch_select);
                i.putExtra("sem",sem_select);
                i.putExtra("subject",subject_select);
                i.putExtra("course",course_select);
                if(isNetworkAvailable()){
                    finish();
                    startActivity(i);
                }else{
                    Toast.makeText(this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
                }}
                else{
                    Toast.makeText(this, "Invalid Details", Toast.LENGTH_SHORT).show();
                }
                break;
            }
        }
    }
    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long l) {
        if(parent.getId()==R.id.spinner_notes_branch) {
            branch_select = parent.getItemAtPosition(position).toString();
            sem.clear();
            for(int i=0;i<sem_json.length();i++)
            {
                JSONObject obj= sem_json.optJSONObject(i);
                if(obj.optString("course").equalsIgnoreCase(course_select))
                    sem.add(obj.optString("sem"));
            }
            adapter1 = new ArrayAdapter<String>(SelectNotes.this,
                    R.layout.custom_spinner,sem);

            adapter1.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            sem_spinner.setAdapter(adapter1);
            sem_spinner.setOnItemSelectedListener(this);
            //Toast.makeText(SelectNotes.this, ""+branch_select, Toast.LENGTH_SHORT).show();
        }
        if(parent.getId()==R.id.spinner_notes_sem) {
            sem_select = parent.getItemAtPosition(position).toString();
            //Toast.makeText(SelectNotes.this, ""+sem_select, Toast.LENGTH_SHORT).show();

            subject.clear();
            for(int i=0;i<subjects_json.length();i++)
            {
                JSONObject obj= subjects_json.optJSONObject(i);
                //  Toast.makeText(context, ""+obj.optString("branch")+obj.optString("sem"), Toast.LENGTH_SHORT).show();
                if(obj.optString("branch").equalsIgnoreCase(branch_select)&&obj.optString("sem").equalsIgnoreCase(sem_select))
                    subject.add(obj.optString("name"));
            }
            adapter4 = new ArrayAdapter<String>(SelectNotes.this,
                    R.layout.custom_spinner,subject);

            adapter4.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            subject_spinner.setAdapter(adapter4);
            subject_spinner.setOnItemSelectedListener(this);

        }
        if(parent.getId()==R.id.spinner_notes_subject) {
            subject_select = parent.getItemAtPosition(position).toString();
            // Toast.makeText(SelectNotes.this, ""+ subject_select, Toast.LENGTH_SHORT).show();
        }
        if(parent.getId()==R.id.spinner_notes_course) {
            course_select = parent.getItemAtPosition(position).toString();
            //Toast.makeText(context, ""+course_select, Toast.LENGTH_SHORT).show();

            branch.clear();
            for(int i=0;i<branch_json.length();i++)
            {
                JSONObject obj= branch_json.optJSONObject(i);
                if(obj.optString("course").equalsIgnoreCase(course_select))
                    branch.add(obj.optString("branch"));
            }
            adapter3 = new ArrayAdapter<String>(SelectNotes.this,
                    R.layout.custom_spinner,branch);

            adapter3.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            branch_spinner.setAdapter(adapter3);
            branch_spinner.setOnItemSelectedListener(this);
        }
    }
    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }
    public class select_Class_Loader extends AsyncTask<Void,Void,String> implements AdapterView.OnItemSelectedListener {

        Context context;

        select_Class_Loader(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= "https://exodia-incredible100rav.c9users.io/android/php/getnoteslist.php";

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return "";

        }


        @Override
        protected void onPreExecute() {
            // Toast.makeText(Dashboard.this, "Yeah", Toast.LENGTH_SHORT).show();
            super.onPreExecute();
            pd = new ProgressDialog(SelectNotes.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait...\nLoading Class Details.");
            pd.setCancelable(false);
            pd.show();
        }

        @Override
        protected void onPostExecute(String result ){
            String[] fadu_data = result.split("``%f%``");
            pd.dismiss();
            writeItems(result);
            course.clear();
            branch.clear();
            sem.clear();
            subject.clear();
            try {
                courses_json =new JSONArray(fadu_data[0]);
                subjects_json = new JSONArray(fadu_data[2]);
                branch_json=new JSONArray(fadu_data[3]);
                sem_json=new JSONArray(fadu_data[1]);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            for(int i=0;i<courses_json.length();i++)
            {
                JSONObject obj= courses_json.optJSONObject(i);
                course.add(obj.optString("course"));
            }
            adapter2 = new ArrayAdapter<String>(SelectNotes.this,
                    R.layout.custom_spinner,course);

            adapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            course_spinner.setAdapter(adapter2);
            course_spinner.setOnItemSelectedListener(this);

        }


        @Override
        public void onItemSelected(AdapterView<?> parent, View view, int position, long l) {
            if(parent.getId()==R.id.spinner_notes_branch) {
                branch_select = parent.getItemAtPosition(position).toString();
                sem.clear();
                for(int i=0;i<sem_json.length();i++)
                {
                    JSONObject obj= sem_json.optJSONObject(i);
                    if(obj.optString("course").equalsIgnoreCase(course_select))
                        sem.add(obj.optString("sem"));
                }
                adapter1 = new ArrayAdapter<String>(SelectNotes.this,
                        R.layout.custom_spinner,sem);

                adapter1.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                sem_spinner.setAdapter(adapter1);
                sem_spinner.setOnItemSelectedListener(this);
                //Toast.makeText(SelectNotes.this, ""+branch_select, Toast.LENGTH_SHORT).show();
            }
            if(parent.getId()==R.id.spinner_notes_sem) {
                sem_select = parent.getItemAtPosition(position).toString();
                //Toast.makeText(SelectNotes.this, ""+sem_select, Toast.LENGTH_SHORT).show();

                subject.clear();
                for(int i=0;i<subjects_json.length();i++)
                {
                    JSONObject obj= subjects_json.optJSONObject(i);
                    //  Toast.makeText(context, ""+obj.optString("branch")+obj.optString("sem"), Toast.LENGTH_SHORT).show();
                    if(obj.optString("branch").equalsIgnoreCase(branch_select)&&obj.optString("sem").equalsIgnoreCase(sem_select)&&obj.optString("course").equalsIgnoreCase(course_select))
                        subject.add(obj.optString("name"));
                }
                adapter4 = new ArrayAdapter<String>(SelectNotes.this,
                        R.layout.custom_spinner,subject);

                adapter4.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                subject_spinner.setAdapter(adapter4);
                subject_spinner.setOnItemSelectedListener(this);

            }
            if(parent.getId()==R.id.spinner_notes_subject) {
                subject_select = parent.getItemAtPosition(position).toString();
                // Toast.makeText(SelectNotes.this, ""+ subject_select, Toast.LENGTH_SHORT).show();
            }
            if(parent.getId()==R.id.spinner_notes_course) {
                course_select = parent.getItemAtPosition(position).toString();
                //Toast.makeText(context, ""+course_select, Toast.LENGTH_SHORT).show();

                branch.clear();
                for(int i=0;i<branch_json.length();i++)
                {
                    JSONObject obj= branch_json.optJSONObject(i);
                    if(obj.optString("course").equalsIgnoreCase(course_select))
                        branch.add(obj.optString("branch"));
                }
                adapter3 = new ArrayAdapter<String>(SelectNotes.this,
                        R.layout.custom_spinner,branch);

                adapter3.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                branch_spinner.setAdapter(adapter3);
                branch_spinner.setOnItemSelectedListener(this);


            }
        }

        @Override
        public void onNothingSelected(AdapterView<?> adapterView) {

        }
    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }
    private void writeItems(String s) {
        String messages;
        File filesDir = getFilesDir();
        File todoFile = new File(filesDir, "notelist.txt");
        try {
            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    private void readItems()  {
        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,"notelist.txt");
        try {
            offline_note_list = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_note_list = "";
        }
    }
    public void refresh_notes(View v){
    if(isNetworkAvailable()){
        select_Class_Loader select_class_loader = new select_Class_Loader(SelectNotes.this);
        select_class_loader.execute();}
    else {
        Toast.makeText(this, "Please Connect To Internet", Toast.LENGTH_SHORT).show();
    }
}

    public void back(View v){
        finish();
    }
}
