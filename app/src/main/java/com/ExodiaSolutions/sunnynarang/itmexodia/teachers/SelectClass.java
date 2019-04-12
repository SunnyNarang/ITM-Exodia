package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.app.Activity;
import android.app.DatePickerDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.text.Html;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.Link;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.apache.commons.io.FileUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Locale;

public class SelectClass extends Activity implements AdapterView.OnItemSelectedListener {
    java.text.SimpleDateFormat sdf;
    private Spinner spinner_sem;
    private Spinner spinner_branch;
    private Spinner spinner_class;
    String c_id="";
    String section_id="",period="";
    String br_id="";
    String tid="";
    private Spinner spinner_course,spinner_subject,spinner_time,spinner_year_batch;
    String name_teacher,roll_teacher;
    ArrayList<String> course = new ArrayList<>();
    ArrayList<String> time = new ArrayList<>();
    ArrayList<String> classes = new ArrayList<>();
    ArrayList<String> branch = new ArrayList<>();
    ArrayList<String> subject = new ArrayList<>();
    ArrayList<String> batch = new ArrayList<>();
    ArrayList<String> year_batch = new ArrayList<String>();
    ArrayAdapter<String> adapter4;
    ArrayAdapter<String> adapter6;
    ArrayAdapter<String>adapter;
    ArrayAdapter<String>adapter3;
    ArrayAdapter<String>adapter7;
    ArrayAdapter<String>adapter_year,adapter_sem;
    TextView dateview;
    ProgressDialog pd;
    Calendar myCalendar;
    String timeStamp,timeStamp1;
    ArrayAdapter<String>adapter2;
    ArrayAdapter<String>adapter5;
    String subject_id="";
    String class_id="";
    String offline_subject_list=null;
    String course_select="",branch_select="",class_select="",sem_select="",subject_select="",select_code="",batch_select="",time_select="",year_batch_select="";
    JSONArray subjects_json=null,classes_json=null,courses_json = null,branch_json=null,sem_json=null,batch_json=null,time_json=null;
    private DatePickerDialog.OnDateSetListener date;
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                SelectClass.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select_class);
        name_teacher=getIntent().getStringExtra("name_teacher");
        roll_teacher=getIntent().getStringExtra("roll_teacher");
        spinner_course = (Spinner)findViewById(R.id.spinner_course);
        spinner_branch = (Spinner)findViewById(R.id.spinner_branch);
        spinner_sem = (Spinner)findViewById(R.id.spinner_sem);
        spinner_class = (Spinner)findViewById(R.id.spinner_class);
        spinner_subject= (Spinner) findViewById(R.id.spinner_subject);
        //spinner_batch = (Spinner) findViewById(R.id.spinner_batch);
        spinner_time = (Spinner) findViewById(R.id.spinner_time);
        spinner_year_batch = (Spinner) findViewById(R.id.spinner_year_batch);


        //year _ batch is static array...
        String []year={"2010","2011","2012","2013","2014","2015","2016","2017"};
        adapter_year= new ArrayAdapter<>(SelectClass.this,
                R.layout.custom_spinner,year);
        spinner_year_batch.setAdapter(adapter_year);
        spinner_year_batch.setOnItemSelectedListener(this);

        //sem is also static array ....
        String []sem={"1","2","3","4","5","6","7","8","9","10"};
        adapter3 = new ArrayAdapter<String>(SelectClass.this,
                R.layout.custom_spinner,sem);
        adapter3.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner_sem.setAdapter(adapter3);
        spinner_sem.setOnItemSelectedListener(this);

        dateview = (TextView) findViewById(R.id.date_view);
        String myFormat = "dd-MM-yyyy"; //In which you need put here
        TextView tv = (TextView) findViewById(R.id.select_class_appbar);
        Typeface custom_font1 = Typeface.createFromAsset(getAssets(), "fonts/TitilliumWeb-Light.ttf");
        tv.setTypeface(custom_font1);
        sdf = new java.text.SimpleDateFormat(myFormat, Locale.US);

        date = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int monthOfYear,
                                  int dayOfMonth) {
                // TODO Auto-generated method stub

                myCalendar = Calendar.getInstance();
                timeStamp1 = sdf.format(myCalendar.getTime());

                myCalendar.set(Calendar.YEAR, year);
                myCalendar.set(Calendar.MONTH, monthOfYear);
                myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                String myFormat = "dd-MM-yyyy"; //In which you need put here
                java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat(myFormat, Locale.US);
                timeStamp = sdf.format(myCalendar.getTime());
                String t1[] = timeStamp.split("-");
                String t2[] = timeStamp1.split("-");

                if (Integer.parseInt(t1[2])>Integer.parseInt(t2[2])||Integer.parseInt(t1[2])==Integer.parseInt(t2[2])&&Integer.parseInt(t1[1])>Integer.parseInt(t2[1])||Integer.parseInt(t1[2])==Integer.parseInt(t2[2])&&Integer.parseInt(t1[1])==Integer.parseInt(t2[1])&&Integer.parseInt(t1[0])>Integer.parseInt(t2[0]))
                {
                    Toast.makeText(SelectClass.this, "Future Date Not Allowed", Toast.LENGTH_SHORT).show();
                    timeStamp=timeStamp1;
                }
                else {
                    dateview.setText(timeStamp);
                    Toast.makeText(SelectClass.this, "DATE SELECTED: " + timeStamp, Toast.LENGTH_SHORT).show();
                }
            }

        };
        myCalendar = Calendar.getInstance();
        timeStamp = sdf.format(myCalendar.getTime());
        dateview.setText(timeStamp);

        readItems();
       // Toast.makeText(this, ""+offline_subject_list.charAt(0), Toast.LENGTH_SHORT).show();
        if(offline_subject_list!=null)
        {
            String[] fadu_data = offline_subject_list.split("``%f%``");
            try {
                courses_json =new JSONArray(fadu_data[0]);
                branch_json=new JSONArray(fadu_data[1]);
                classes_json = new JSONArray(fadu_data[2]);
                subjects_json = new JSONArray(fadu_data[3]);

                if(fadu_data.length==5)
                    time_json = new JSONArray(fadu_data[4]);
            } catch (JSONException e) {
                e.printStackTrace();
            }


            if(courses_json==null){
                select_Class_Loader loader= new select_Class_Loader(SelectClass.this);             loader.execute();
                Toast.makeText(SelectClass.this, "Courses Not Found", Toast.LENGTH_SHORT).show();
            }

            else if(subjects_json==null){
                select_Class_Loader loader= new select_Class_Loader(SelectClass.this);             loader.execute();
                Toast.makeText(SelectClass.this, "Subjects Not Found", Toast.LENGTH_SHORT).show();
            }

            else if(classes_json==null){
                select_Class_Loader loader= new select_Class_Loader(SelectClass.this);             loader.execute();
                Toast.makeText(SelectClass.this, "Classes Not Found", Toast.LENGTH_SHORT).show();
            }

            else if(branch_json==null){
                select_Class_Loader loader= new select_Class_Loader(SelectClass.this);             loader.execute();
                Toast.makeText(SelectClass.this, "Branches Not Found", Toast.LENGTH_SHORT).show();
            }




            else if(time_json==null){
                select_Class_Loader loader= new select_Class_Loader(SelectClass.this);             loader.execute();
                Toast.makeText(SelectClass.this, "Routines Not Found", Toast.LENGTH_SHORT).show();
            }

            //Toast.makeText(this, ""+subjects_json, Toast.LENGTH_SHORT).show();
            // course = new String[courses_json.length()];
            if(courses_json!=null&&time_json!=null){
                for(int i=0;i<courses_json.length();i++)
                {
                    JSONObject obj= courses_json.optJSONObject(i);
                    course.add(obj.optString("course"));
                }
                adapter = new ArrayAdapter<String>(SelectClass.this,
                        R.layout.custom_spinner,course);
                adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                spinner_course.setAdapter(adapter);
                spinner_course.setOnItemSelectedListener(SelectClass.this);
                //Toast.makeText(this, ""+obj1.optString("type"), Toast.LENGTH_SHORT).show();
            }}

        else{
            if(isNetworkAvailable()){
                final select_Class_Loader loader = new select_Class_Loader(SelectClass.this);
                loader.execute();

                Handler handler = new Handler();
                handler.postDelayed(new Runnable()
                {
                    @Override
                    public void run() {
                        if (loader.getStatus() == AsyncTask.Status.RUNNING )
                        {loader.cancel(true);
                            Toast.makeText(SelectClass.this, "Time OUT", Toast.LENGTH_SHORT).show();
                            if(pd.isIndeterminate())
                                pd.dismiss();
                        }
                    }
                }, 20000 );
            }else{
                Toast.makeText(SelectClass.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
            }
        }

    }

    public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {
        if(courses_json!=null&&subjects_json!=null&&classes_json!=null&&time_json!=null) {
            if (parent.getId() == R.id.spinner_course) {
                course_select = parent.getItemAtPosition(position).toString();
                //Toast.makeText(SelectClass.this, course_select, Toast.LENGTH_SHORT).show();
                c_id = "";
                //branch=new String[length];
                for (int i = 0; i < courses_json.length(); i++) {
                    JSONObject obj = courses_json.optJSONObject(i);
                    if (course_select.equals(obj.optString("course"))) {
                        c_id = obj.optString("c_id");
                    }
                }
                branch.clear();
                for (int i = 0; i < branch_json.length(); i++) {
                    JSONObject obj = branch_json.optJSONObject(i);
                    if (c_id.equalsIgnoreCase(obj.optString("c_id"))) {
                        branch.add(obj.optString("br_name"));
                    }
                }
                adapter2 = new ArrayAdapter<String>(SelectClass.this,
                        R.layout.custom_spinner, branch);

                adapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                spinner_branch.setAdapter(adapter2);
                spinner_branch.setOnItemSelectedListener(this);
            }

            if (parent.getId() == R.id.spinner_branch) {

                branch_select = parent.getItemAtPosition(position).toString();

                br_id = "";
                for (int i = 0; i < branch_json.length(); i++) {
                    JSONObject obj = branch_json.optJSONObject(i);
                    try {
                        if (branch_select.equals(obj.optString("br_name")) && c_id.equalsIgnoreCase(obj.getString("c_id"))) {
                            br_id = obj.optString("br_id");
                            //Toast.makeText(this, ""+br_id, Toast.LENGTH_SHORT).show();
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }

                getSubjectSpinners();
                getClassSpinners();
                //Toast.makeText(this,, Toast.LENGTH_SHORT).show();
            }
            if (parent.getId() == R.id.spinner_year_batch) {

                year_batch_select = parent.getItemAtPosition(position).toString();
                getSubjectSpinners();
                getClassSpinners();
                //Toast.makeText(this,, Toast.LENGTH_SHORT).show();
            }
            if (parent.getId() == R.id.spinner_batch) {

                batch_select = parent.getItemAtPosition(position).toString();

                // Toast.makeText(this, ""+batch_select, Toast.LENGTH_SHORT).show();
            }
            if (parent.getId() == R.id.spinner_time) {

                time_select = parent.getItemAtPosition(position).toString();
                for (int i = 0; i < time_json.length(); i++) {
                    JSONObject obj = time_json.optJSONObject(i);
                    try {
                        String t = obj.optString("from") + " - " + obj.optString("to");
                        if (section_id.equalsIgnoreCase(obj.optString("section_id")) && time_select.equalsIgnoreCase(t)) {
                            period = obj.getString("order");
                        }

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                //Toast.makeText(this, "period : "+period, Toast.LENGTH_SHORT).show();
            }


            if (parent.getId() == R.id.spinner_sem) {

                sem_select = parent.getItemAtPosition(position).toString();
                getSubjectSpinners();
                getClassSpinners();
            }

            if (parent.getId() == R.id.spinner_class) {

                class_select = parent.getItemAtPosition(position).toString();


                for (int i = 0; i < classes_json.length(); i++) {
                    JSONObject obj = classes_json.optJSONObject(i);
                    try {
                        if (class_select.equalsIgnoreCase(obj.getString("sectionName")) && c_id.equalsIgnoreCase(obj.getString("c_id")) && br_id.equalsIgnoreCase(obj.getString("br_id")) && sem_select.equalsIgnoreCase(obj.getString("sem")) && year_batch_select.equalsIgnoreCase(obj.getString("batch"))) {
                            section_id = obj.getString("section");
                            tid = obj.getString("tid");
                        }

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                // Toast.makeText(this, "section_id : '"+section_id+"'", Toast.LENGTH_SHORT).show();
                time.clear();
                if (time_json != null) {
                    for (int i = 0; i < time_json.length(); i++) {
                        JSONObject obj = time_json.optJSONObject(i);
                        if (section_id.equalsIgnoreCase(obj.optString("section_id")) && !time.contains(obj.optString("from") + " - " + obj.optString("to")))
                            time.add(obj.optString("from") + " - " + obj.optString("to"));
                    }
                }
                adapter7 = new ArrayAdapter<String>(SelectClass.this,
                        R.layout.custom_spinner, time);
                adapter7.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                spinner_time.setAdapter(adapter7);
                spinner_time.setOnItemSelectedListener(SelectClass.this);

            }


            if (parent.getId() == R.id.spinner_subject) {
                subject_select = parent.getItemAtPosition(position).toString();
            }
        }
        }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }

    public void search(View v){
        //Toast.makeText(this, ""+subject_select, Toast.LENGTH_SHORT).show();
        Intent i = new Intent(SelectClass.this,MyActivity.class);
        String myFormat = "yyyy-MM-dd"; //In which you need put here
        java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat(myFormat, Locale.US);
        timeStamp = sdf.format(myCalendar.getTime());
//        Toast.makeText(this, ""+timeStamp, Toast.LENGTH_SHORT).show();
        timeStamp = sdf.format(myCalendar.getTime());
        if(!course_select.equalsIgnoreCase("")&&!subject_select.equalsIgnoreCase("")&&!class_select.equalsIgnoreCase("")&&!sem_select.equalsIgnoreCase("")&&!branch_select.equalsIgnoreCase(""))
        {

            i.putExtra("roll_teacher",roll_teacher);
            i.putExtra("name_teacher",name_teacher);
            i.putExtra("class_select",class_select);
            i.putExtra("sem_select",sem_select);
            i.putExtra("course_select",course_select);
            i.putExtra("branch_select",branch_select);
            i.putExtra("br_id",br_id);
            i.putExtra("subject_select",subject_select);
            i.putExtra("c_id",c_id);
            i.putExtra("subject_id",subject_id);
            i.putExtra("timestamp",timeStamp);
            i.putExtra("section_id",section_id);
            i.putExtra("batch",year_batch_select);
            i.putExtra("time",time_select);
            i.putExtra("period",period);
            i.putExtra("tid",tid);
            finish();
            startActivity(i);

        }
        else{
            Toast.makeText(this, "Please Select All Fields", Toast.LENGTH_SHORT).show();
        }
    }

    public void refresh(View v){
        if(isNetworkAvailable()){
            select_Class_Loader loader= new select_Class_Loader(SelectClass.this);
            loader.execute();
        }else{
            Toast.makeText(SelectClass.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
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

            String login_url= null;
            if( Link.getInstance().getHashMapLink().containsKey("take_attendance_spinners_list")){
                login_url = Link.getInstance().getHashMapLink().get("take_attendance_spinners_list");
            }

            try{
                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestProperty("Accept","text/html");
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
            //Toast.makeText(SelectClass.this, "", Toast.LENGTH_SHORT).show();
            super.onPreExecute();
            pd = new ProgressDialog(SelectClass.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait...\nLoading Class Details.");
            pd.setCancelable(false);
            pd.show();
        }

        @Override
        protected void onPostExecute(String result ){
            String[] fadu_data = result.split("``%f%``");
            course.clear();
            writeItems(result);
            batch.clear();
            try {
                courses_json =new JSONArray(fadu_data[0]);
              //  Toast.makeText(context, "course done", Toast.LENGTH_SHORT).show();
                branch_json=new JSONArray(fadu_data[1]);
                //Toast.makeText(context, "branch done", Toast.LENGTH_SHORT).show();
                classes_json = new JSONArray(fadu_data[2]);
                //Toast.makeText(context, "classes done", Toast.LENGTH_SHORT).show();
                subjects_json = new JSONArray(fadu_data[3]);
                //Toast.makeText(context, "subjects done", Toast.LENGTH_SHORT).show();
                if(fadu_data.length==5)
                {time_json = new JSONArray(fadu_data[4]);
                 //   Toast.makeText(context, "time done", Toast.LENGTH_SHORT).show();
                     }
            } catch (JSONException e) {
                e.printStackTrace();
            }

            if(courses_json==null){
                finish();
                Toast.makeText(context, "Courses Not Found", Toast.LENGTH_SHORT).show();
            }

            else if(subjects_json==null){
                finish();
                Toast.makeText(context, "Subjects Not Found", Toast.LENGTH_SHORT).show();
            }

            else if(classes_json==null){
                finish();
                Toast.makeText(context, "Classes Not Found", Toast.LENGTH_SHORT).show();
            }

            else if(branch_json==null){
                finish();
                Toast.makeText(context, "Branches Not Found", Toast.LENGTH_SHORT).show();
            }

            else if(time_json==null){
                finish();
                Toast.makeText(context, "Routines Not Found", Toast.LENGTH_SHORT).show();
            }

            if(courses_json!=null&&time_json!=null){      // course = new String[courses_json.length()];
                for (int i = 0; i < courses_json.length(); i++) {
                    JSONObject obj = courses_json.optJSONObject(i);
                    course.add(obj.optString("course"));
                }
                adapter = new ArrayAdapter<String>(SelectClass.this,
                        R.layout.custom_spinner, course);
                adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                spinner_course.setAdapter(adapter);
                spinner_course.setOnItemSelectedListener(SelectClass.this);
            }
            pd.dismiss();

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
    public void chooseDate(View v){
        new DatePickerDialog(SelectClass.this, date, myCalendar
                .get(Calendar.YEAR), myCalendar.get(Calendar.MONTH),
                myCalendar.get(Calendar.DAY_OF_MONTH)).show();
        dateview.setText(timeStamp);
    }

    public void back(View v){
        finish();
    }
    public void getSubjectSpinners(){
        subject.clear();
        // Toast.makeText(this, "c_id:"+c_id+"br_id:"+br_id+"sem:"+sem_select+"year:"+year_batch_select, Toast.LENGTH_SHORT).show();
        for(int i=0;i<subjects_json.length();i++){
            JSONObject obj = subjects_json.optJSONObject(i);
            try {
                if(c_id.equalsIgnoreCase(obj.getString("c_id"))&&br_id.equalsIgnoreCase(obj.getString("br_id"))&&sem_select.equalsIgnoreCase(obj.getString("sem"))&&year_batch_select.equalsIgnoreCase(obj.getString("batch"))){
                    subject.add(obj.getString("subject"));
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }}
            adapter5 = new ArrayAdapter<String>(SelectClass.this,
                    R.layout.custom_spinner,subject);
            adapter5.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinner_subject.setAdapter(adapter5);
            spinner_subject.setOnItemSelectedListener(this);

    }
    public void getClassSpinners(){
        classes.clear();
        //Toast.makeText(this, "c_id:"+c_id+"br_id:"+br_id+"sem:"+sem_select+"year:"+year_batch_select, Toast.LENGTH_SHORT).show();
        for(int i=0;i<classes_json.length();i++){
            JSONObject obj = classes_json.optJSONObject(i);
            try {
                if(c_id.equalsIgnoreCase(obj.getString("c_id"))&&br_id.equalsIgnoreCase(obj.getString("br_id"))&&sem_select.equalsIgnoreCase(obj.getString("sem"))&&year_batch_select.equalsIgnoreCase(obj.getString("batch"))){
                    classes.add(obj.getString("sectionName"));
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        adapter4 = new ArrayAdapter<String>(SelectClass.this,
                R.layout.custom_spinner,classes);
        adapter4.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner_class.setAdapter(adapter4);


        spinner_class.setOnItemSelectedListener(this);
    }

}


