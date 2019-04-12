package com.ExodiaSolutions.sunnynarang.itmexodia;

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
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

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

public class ViewAttendanceTeacher extends AppCompatActivity implements AdapterView.OnItemSelectedListener {
    
    private String offline_subject_list = null,roll_teacher ;


    ArrayList<String> course = new ArrayList<>();
    ArrayList<String> sem = new ArrayList<>();
    ArrayList<String> classes = new ArrayList<>();
    ArrayList<String> branch = new ArrayList<>();
    ArrayList<String> subject = new ArrayList<>();
    ArrayList<String> batch = new ArrayList<>();
    ArrayAdapter<String> adapter4;
    ArrayAdapter<String> adapter6;
    ArrayAdapter<String>adapter;
    ArrayAdapter<String>adapter3;
   String class_id="",select_type;
    ArrayAdapter<String>adapter2;
    ArrayAdapter<String>adapter5;
    ProgressDialog pd;
    String course_select="",branch_select="",class_select="",sem_select="",subject_select="",select_code="",batch_select="";
    JSONArray subjects_json=null,classes_json=null,courses_json = null,branch_json=null,sem_json=null,batch_json=null;

    private Spinner spinner_course,spinner_subject,spinner_batch,spinner_class,spinner_branch,spinner_sem;

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
               ViewAttendanceTeacher.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_attendance_teacher);

        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();
        spinner_course = (Spinner)findViewById(R.id.spinner_course);
        spinner_branch = (Spinner)findViewById(R.id.spinner_branch);
        spinner_sem = (Spinner)findViewById(R.id.spinner_sem);
        spinner_class = (Spinner)findViewById(R.id.spinner_class);
        spinner_subject= (Spinner) findViewById(R.id.spinner_subject);
        spinner_batch = (Spinner) findViewById(R.id.spinner_batch);
        TextView tv = (TextView) findViewById(R.id.view_att_appbar);
        Typeface custom_font1 = Typeface.createFromAsset(getAssets(), "fonts/TitilliumWeb-Light.ttf");
        tv.setTypeface(custom_font1);
       roll_teacher = getIntent().getStringExtra("roll");
        readItems();
      //  Toast.makeText(this, offline_subject_list, Toast.LENGTH_SHORT).show();
        if(offline_subject_list!=null)
        {
            String[] fadu_data = offline_subject_list.split("``%f%``");
            try {
                courses_json =new JSONArray(fadu_data[0]);
                subjects_json = new JSONArray(fadu_data[4]);
                classes_json = new JSONArray(fadu_data[3]);
                branch_json=new JSONArray(fadu_data[1]);
                sem_json=new JSONArray(fadu_data[2]);
                batch_json = new JSONArray(fadu_data[5]);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            // course = new String[courses_json.length()];
            for(int i=0;i<courses_json.length();i++)
            {
                JSONObject obj= courses_json.optJSONObject(i);
                course.add(obj.optString("course"));
            }
            adapter = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,course);
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_course.setAdapter(adapter);
            spinner_course.setOnItemSelectedListener(ViewAttendanceTeacher.this);
            batch.add("ALL");
            for(int i=0;i<batch_json.length();i++)
            {
                JSONObject obj= batch_json.optJSONObject(i);
                batch.add(obj.optString("batch"));
            }
            adapter6 = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,batch);
            adapter6.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_batch.setAdapter(adapter6);
            spinner_batch.setOnItemSelectedListener(ViewAttendanceTeacher.this);

        }

        else{
            if(isNetworkAvailable()){
                final ViewAttendanceTeacher.select_Class_Loader loader = new ViewAttendanceTeacher.select_Class_Loader(ViewAttendanceTeacher.this);
                loader.execute();

                Handler handler = new Handler();
                handler.postDelayed(new Runnable()
                {
                    @Override
                    public void run() {
                        if ( loader.getStatus() == AsyncTask.Status.RUNNING )
                        {loader.cancel(true);
                            Toast.makeText(ViewAttendanceTeacher.this, "Time OUT", Toast.LENGTH_SHORT).show();
                            if(pd.isIndeterminate())
                            pd.dismiss();
                        }
                    }
                }, 20000 );
            }else{
                Toast.makeText(ViewAttendanceTeacher.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
            }
        }
    }


    public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {
        if(parent.getId()==R.id.spinner_course){
            course_select = parent.getItemAtPosition(position).toString();
            branch.clear();
            for(int i=0;i<branch_json.length();i++){
                JSONObject obj =branch_json.optJSONObject(i);
                if(course_select.equalsIgnoreCase(obj.optString("course"))){
                    branch.add(obj.optString("branch"));
                }
            }

            adapter2 = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,branch);

            adapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_branch.setAdapter(adapter2);
            spinner_branch.setOnItemSelectedListener(this);





        }
        if(parent.getId()==R.id.spinner_branch){

            branch_select = parent.getItemAtPosition(position).toString();
            //Toast.makeText(this,, Toast.LENGTH_SHORT).show();
            sem.clear();
            for(int i=0;i<sem_json.length();i++){
                JSONObject obj =sem_json.optJSONObject(i);
                //  Toast.makeText(this, obj.optString("name"), Toast.LENGTH_SHORT).show();
                if(course_select.equalsIgnoreCase(obj.optString("course"))){
                    sem.add(obj.optString("sem"));
                }
            }

            adapter3 = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,sem);

            adapter3.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_sem.setAdapter(adapter3);
            spinner_sem.setOnItemSelectedListener(this);
        }
        if(parent.getId()==R.id.spinner_batch){

            batch_select = parent.getItemAtPosition(position).toString();
            // Toast.makeText(this, ""+batch_select, Toast.LENGTH_SHORT).show();
        }


        if(parent.getId()==R.id.spinner_sem){

            sem_select = parent.getItemAtPosition(position).toString();
            // Toast.makeText(this, sem_select, Toast.LENGTH_SHORT).show();
            classes.clear();
            for(int i=0;i<classes_json.length();i++){
                JSONObject obj =classes_json.optJSONObject(i);
                //  Toast.makeText(this, obj.optString("name"), Toast.LENGTH_SHORT).show();
                if(sem_select.equalsIgnoreCase(obj.optString("sem"))&&branch_select.equalsIgnoreCase(obj.optString("branch"))&&course_select.equalsIgnoreCase(obj.optString("course"))){
                    classes.add(obj.optString("name"));
                }
            }


            adapter4 = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,classes);

            adapter4.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_class.setAdapter(adapter4);
            spinner_class.setOnItemSelectedListener(this);


        }

        if(parent.getId()==R.id.spinner_class){

            class_select = parent.getItemAtPosition(position).toString();
            for(int j =0;j<classes_json.length();j++)
            {
                JSONObject obj = classes_json.optJSONObject(j);
                if(class_select.equalsIgnoreCase(obj.optString("name"))&&sem_select.equalsIgnoreCase(obj.optString("sem"))&&branch_select.equalsIgnoreCase(obj.optString("branch"))&&course_select.equalsIgnoreCase(obj.optString("course")))
                {

                    class_id = obj.optString("id");
                }
            }
           // Toast.makeText(this, ""+class_id, Toast.LENGTH_SHORT).show();
            subject.clear();
            for(int i=0;i<subjects_json.length();i++){
                JSONObject obj =subjects_json.optJSONObject(i);
                //  Toast.makeText(this, obj.optString("name"), Toast.LENGTH_SHORT).show();
                if(class_id.equalsIgnoreCase(obj.optString("class_id"))){
                    subject.add("["+obj.optString("type")+"] - "+obj.optString("code")+" - "+obj.optString("name"));
                }
            }

            adapter5 = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,subject);

            adapter5.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_subject.setAdapter(adapter5);
            spinner_subject.setOnItemSelectedListener(this);

        }


        if(parent.getId()==R.id.spinner_subject)
        {
            subject_select = parent.getItemAtPosition(position).toString();
            String s = subject.get(position);
            String code[] = s.split(" - ");
            select_code = code[1];
            //Toast.makeText(this, ""+code[0], Toast.LENGTH_SHORT).show();
            select_type = ""+code[0].charAt(1);
        }
    }
    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }

    public void search(View v){
        if(!course_select.equalsIgnoreCase("")&&!subject_select.equalsIgnoreCase("")&&!class_select.equalsIgnoreCase("")&&!batch_select.equalsIgnoreCase("")&&!sem_select.equalsIgnoreCase("")&&!branch_select.equalsIgnoreCase(""))
        {
            String class_id="",subject_id="";
        Intent i = new Intent(ViewAttendanceTeacher.this, com.ExodiaSolutions.sunnynarang.itmexodia.ViewAttendanceTeacherLv.class);
        for(int j =0;j<classes_json.length();j++)
        {
            JSONObject obj = classes_json.optJSONObject(j);
            if(class_select.equalsIgnoreCase(obj.optString("name"))&&sem_select.equalsIgnoreCase(obj.optString("sem"))&&branch_select.equalsIgnoreCase(obj.optString("branch"))&&course_select.equalsIgnoreCase(obj.optString("course")))
            {
                class_id = obj.optString("id");
            }
        }

        for(int j =0;j<subjects_json.length();j++)
        {
            JSONObject obj = subjects_json.optJSONObject(j);
            if(class_id.equalsIgnoreCase(obj.optString("class_id"))&&select_code.equalsIgnoreCase(obj.optString("code"))&&select_type.equalsIgnoreCase(obj.optString("type")))
            {
                subject_id = obj.optString("id");
            }
        }

        i.putExtra("roll_teacher",roll_teacher);
        i.putExtra("class_select",class_select);
        i.putExtra("sem_select",sem_select);
        i.putExtra("course_select",course_select);
        i.putExtra("branch_select",branch_select);
        i.putExtra("subject_select",subject_select);
        i.putExtra("class_id",class_id);
        i.putExtra("subject_id",subject_id);
        i.putExtra("batch",batch_select);
            Toast.makeText(this, ""+subject_id+" "+class_id+" "+roll_teacher, Toast.LENGTH_SHORT).show();
        if(isNetworkAvailable()){
             finish();
            startActivity(i);
            }else{
            Toast.makeText(this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
        }
        }
        else{
            Toast.makeText(this, "Please Select All Details..", Toast.LENGTH_SHORT).show();
        }
    }
    public void refresh(View v){
        if(isNetworkAvailable()){
            ViewAttendanceTeacher.select_Class_Loader loader = new ViewAttendanceTeacher.select_Class_Loader(ViewAttendanceTeacher.this);
            loader.execute();
        }else{
            Toast.makeText(ViewAttendanceTeacher.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
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
        File todoFile = new File(filesDir, "subjectlist.txt");
        try {
            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    private void readItems()  {
        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,"subjectlist.txt");
        try {
            offline_subject_list = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_subject_list = null;
        }
    }
    public class select_Class_Loader extends AsyncTask<Void,Void,String> {

        Context context;

        select_Class_Loader(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= "https://exodia-incredible100rav.c9users.io/android/php/getsubjectlist.php";

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


            return null;

        }


        @Override
        protected void onPreExecute() {
            // Toast.makeText(Dashboard.this, "Yeah", Toast.LENGTH_SHORT).show();
            super.onPreExecute();
            pd = new ProgressDialog(ViewAttendanceTeacher.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait...\nLoading Class Details.");
            pd.setCancelable(false);
            pd.show();
        }

        @Override
        protected void onPostExecute(String result ){
            String[] fadu_data = result.split("``%f%``");
            writeItems(result);
            course.clear();
            batch.clear();
            // Toast.makeText(ViewAttendanceTeacher.this, fadu_data[5], Toast.LENGTH_SHORT).show();
            try {
                courses_json =new JSONArray(fadu_data[0]);
                subjects_json = new JSONArray(fadu_data[4]);
                classes_json = new JSONArray(fadu_data[3]);
                branch_json=new JSONArray(fadu_data[1]);
                sem_json=new JSONArray(fadu_data[2]);
                batch_json = new JSONArray(fadu_data[5]);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            // course = new String[courses_json.length()];
            for(int i=0;i<courses_json.length();i++)
            {
                JSONObject obj= courses_json.optJSONObject(i);
                course.add(obj.optString("course"));
            }
            adapter = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,course);
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_course.setAdapter(adapter);
            spinner_course.setOnItemSelectedListener(ViewAttendanceTeacher.this);
            batch.add("ALL");
            for(int i=0;i<batch_json.length();i++)
            {
                JSONObject obj= batch_json.optJSONObject(i);
                batch.add(obj.optString("batch"));
            }
            adapter6 = new ArrayAdapter<String>(ViewAttendanceTeacher.this,
                    R.layout.custom_spinner,batch);
            adapter6.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_batch.setAdapter(adapter6);
            spinner_batch.setOnItemSelectedListener(ViewAttendanceTeacher.this);
            pd.dismiss();
        }
    }

    public void back(View v){
        finish();
    }
}
